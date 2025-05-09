import React, { useState, useEffect, useRef, useCallback } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import ChatLayout from '@/Layouts/ChatLayout';
import ChatSidebar from '@/Components/Chat/ChatSidebar';
import ChatMain from './ChatMain';
import axios from 'axios';
import Pusher from 'pusher-js';

export default function Index() {
  const { props } = usePage();
  const { auth, conversations, contacts, activeConversation } = props;

  const [currentConversation, setCurrentConversation] = useState(activeConversation || null);
  const [allConversations, setAllConversations] = useState(conversations || []);
  const [messages, setMessages] = useState([]);
  const [isLoading, setIsLoading] = useState(false);
  const [userStatus, setUserStatus] = useState('online');

  const pusherRef = useRef(null);
  const channelsRef = useRef({});
  const pendingTemp = useRef({});
  const heartbeatRef = useRef(null);
  const reconnectAttempts = useRef(0);
  const maxReconnectAttempts = 5;
  const reconnectDelay = 3000;

  const updateUserStatusUI = useCallback((userId, status) => {
    setAllConversations(prev => prev.map(conv => {
      const participant = conv.participants?.[0];
      if (participant && participant.id === userId) {
        return {
          ...conv,
          participants: [{
            ...participant,
            online_status: status
          }]
        };
      }
      return conv;
    }));

    if (currentConversation?.other_participant?.id === userId) {
      setCurrentConversation(prev => ({
        ...prev,
        other_participant: {
          ...prev.other_participant,
          online_status: status
        }
      }));
    }
  }, [currentConversation]);

  const handleConnectionState = useCallback(() => {
    if (!pusherRef.current) return;

    pusherRef.current.connection.bind('state_change', states => {
      const { current: currentState } = states;
      console.log('Connection state:', currentState);

      if (currentState === 'disconnected' || currentState === 'failed') {
        if (reconnectAttempts.current < maxReconnectAttempts) {
          setTimeout(() => {
            console.log('Attempting to reconnect...');
            reconnectAttempts.current += 1;
            pusherRef.current.connect();
          }, reconnectDelay);
        }
      }

      if (currentState === 'connected') {
        reconnectAttempts.current = 0;
        startHeartbeat();
      }
    });
  }, []);

  const startHeartbeat = useCallback(() => {
    if (heartbeatRef.current) {
      clearInterval(heartbeatRef.current);
    }

    heartbeatRef.current = setInterval(async () => {
      try {
        const response = await axios.post('/chat/heartbeat');
        if (!response.data.success) {
          throw new Error('Heartbeat failed');
        }
      } catch (error) {
        console.error('Heartbeat error:', error);
        if (pusherRef.current) {
          pusherRef.current.disconnect();
          pusherRef.current.connect();
        }
      }
    }, 30000);
  }, []);

  useEffect(() => {
    const initializePusher = () => {
      pusherRef.current = new Pusher('68e754591a83be75b54c', {
        cluster: 'ap2',
        authEndpoint: '/broadcasting/auth',
        auth: {
          headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
          withCredentials: true
        }
      });

      handleConnectionState();

      const statusChannel = pusherRef.current.subscribe('private-user-status');
      
      statusChannel.bind('UserStatusChanged', data => {
        updateUserStatusUI(data.user_id || data.id, data.status);
      });

      statusChannel.bind('user.status', data => {
        updateUserStatusUI(data.user_id || data.id, data.status);
      });

      pusherRef.current.connection.bind('error', error => {
        console.error('Pusher connection error:', error);
        if (error.data.code === 4004) {
          window.location.reload();
        }
      });

      updateUserStatus('online');
      startHeartbeat();
    };

    initializePusher();

    const handleVisibilityChange = () => {
      if (document.hidden) {
        if (heartbeatRef.current) {
          clearInterval(heartbeatRef.current);
        }
        if (pusherRef.current) {
          pusherRef.current.disconnect();
        }
      } else {
        if (pusherRef.current) {
          pusherRef.current.connect();
        }
        startHeartbeat();
      }
    };

    document.addEventListener('visibilitychange', handleVisibilityChange);

    return () => {
      document.removeEventListener('visibilitychange', handleVisibilityChange);
      
      if (heartbeatRef.current) {
        clearInterval(heartbeatRef.current);
      }

      if (pusherRef.current) {
        Object.values(channelsRef.current).forEach(channel => {
          pusherRef.current.unsubscribe(channel);
        });
        pusherRef.current.unsubscribe('private-user-status');
        pusherRef.current.disconnect();
      }

      updateUserStatus('offline');
    };
  }, [handleConnectionState, startHeartbeat, updateUserStatusUI]);

  useEffect(() => {
    if (!pusherRef.current) return;

    Object.values(channelsRef.current).forEach(ch => pusherRef.current.unsubscribe(ch));
    channelsRef.current = {};

    allConversations.forEach(c => {
      const notifyOnly = c.id !== currentConversation?.id;
      subscribeToConversation(c.id, notifyOnly);
    });
  }, [allConversations]);

  useEffect(() => {
    if (!currentConversation) return;

    let cancelled = false;
    (async () => {
      await loadMessages(currentConversation.id);
      if (!cancelled) await markAsRead(currentConversation.id);
    })();

    pendingTemp.current = {};
    return () => { cancelled = true; };
  }, [currentConversation?.id]);

  const subscribeToConversation = useCallback((conversationId, notifyOnly) => {
    const channelName = `private-chat.${conversationId}`;

    if (channelsRef.current[conversationId]) {
      pusherRef.current.unsubscribe(channelsRef.current[conversationId]);
    }
    channelsRef.current[conversationId] = channelName;
    const channel = pusherRef.current.subscribe(channelName);

    channel.bind('new.message', data => {
      if (!data) return;

      if (notifyOnly || currentConversation?.id !== data.conversation_id) {
        updateConversationUnreadBadge(data.conversation_id);
        updateConversationLastMessage(data.conversation_id, data);
        return;
      }

      setMessages(prev => {
        if (prev.some(m => m.id === data.id)) return prev;

        if (data.sender.id === auth.user.id) {
          const tempIndex = prev.findIndex(m =>
            m.isOptimistic && m.conversation_id === data.conversation_id
          );
          if (tempIndex !== -1) {
            const clone = [...prev];
            clone[tempIndex] = data;
            delete pendingTemp.current[clone[tempIndex].id];
            return clone;
          }
        }

        return [...prev, data];
      });

      if (data.sender.id !== auth.user.id) markAsRead(data.conversation_id);
    });

    channel.bind('messages.read', ({ conversation_id, user_id }) => {
      if (currentConversation?.id === conversation_id && user_id !== auth.user.id) {
        setMessages(prev => prev.map(m =>
          m.sender.id === auth.user.id ? { ...m, is_read: true } : m
        ));
      }
    });
  }, [currentConversation, auth.user.id]);

  const loadMessages = async id => {
    setIsLoading(true);
    try {
      const { data } = await axios.get(`/chat/conversations/${id}/messages`);
      setMessages(data.messages || []);
    } finally {
      setIsLoading(false);
    }
  };

  const sendMessage = async (text, files = []) => {
    if ((!text.trim() && !files.length) || !currentConversation) return false;

    try {
      const formData = new FormData();
      formData.append('conversation_id', currentConversation.id);
      formData.append('message', text.trim());
      files.forEach((file, i) => formData.append(`attachments[${i}]`, file));

      // Wait for the API to save the message – do **not** touch messages[] here
      await axios.post('/chat/messages', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content'),
        },
      });

      // The new message will arrive via Pusher (new.message) → handled in subscribeToConversation
      return true;
    } catch (err) {
      console.error('Error sending message:', err);
      return false;
    }
  };

  const markAsRead = async id => {
    await axios.post('/chat/conversations/read', { conversation_id: id });
    setAllConversations(prev => prev.map(c =>
      c.id === id ? { ...c, unread_count: 0 } : c
    ));
  };

  const updateConversationUnreadBadge = id => {
    setAllConversations(prev => prev.map(c =>
      c.id === id ? { ...c, unread_count: (c.unread_count || 0) + 1 } : c
    ));
  };

  const updateConversationLastMessage = (id, msg) => {
    setAllConversations(prev => {
      const updated = prev.map(c =>
        c.id === id
          ? {
            ...c,
            latest_message: {
              message: msg.message,
              created_at: msg.created_at,
              formatted_time: msg.formatted_time,
              has_attachments: (msg.attachments || []).length > 0
            }
          }
          : c
      );
      const sel = updated.find(c => c.id === id);
      return sel ? [sel, ...updated.filter(c => c.id !== id)] : updated;
    });
  };

  const updateUserStatus = async status => {
    setUserStatus(status);
    try {
      await axios.post('/chat/status', { status });
    } catch (error) {
      console.error('Failed to update status:', error);
    }
  };

  const startNewConversation = async userId => {
    const { data } = await axios.post('/chat/conversations', { user_id: userId });
    const newId = data.conversation_id;

    const existing = allConversations.find(c => c.id === newId);
    if (!existing) {
      const { data: convData } = await axios.get(`/chat/conversations/${newId}/messages`);
      setAllConversations(prev => [
        {
          id: newId,
          type: convData.conversation.type,
          participants: [convData.conversation.other_participant],
          latest_message: null,
          unread_count: 0
        },
        ...prev
      ]);
      setCurrentConversation(convData.conversation);
      setMessages(convData.messages || []);
    } else {
      setCurrentConversation({
        id: existing.id,
        type: existing.type,
        other_participant: existing.participants[0]
      });
      await loadMessages(existing.id);
    }
    subscribeToConversation(newId, false);
  };

  return (
    <ChatLayout title="Chat">
      <Head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        <link rel="stylesheet" href="/dashboard-assets/css/chat.css" />
      </Head>

      <div className="container-fluid py-4">
        <div className="row">
          <div className="col-lg-12">
            <div className="card border-0 shadow-card mb-4">
              <div className="card-body p-0">
                <div className="chat-container">
                  <ChatSidebar
                    conversations={allConversations}
                    contacts={contacts}
                    currentUser={auth.user}
                    activeConversationId={currentConversation?.id}
                    userStatus={userStatus}
                    onStatusChange={updateUserStatus}
                    onConversationSelect={setCurrentConversation}
                    onStartNewConversation={startNewConversation}
                  />

                  <ChatMain
                    currentConversation={currentConversation}
                    messages={messages}
                    isLoading={isLoading}
                    currentUser={auth.user}
                    onSendMessage={sendMessage}
                    onMarkAsRead={() => currentConversation && markAsRead(currentConversation.id)}
                    contacts={contacts}
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </ChatLayout>
  );
}