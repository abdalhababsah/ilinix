import React, { useState, useEffect, useRef } from 'react';

export default function ChatMain({
  currentConversation,
  messages,
  isLoading,
  currentUser,
  onSendMessage,
  onMarkAsRead,
  contacts
}) {
  const [messageText, setMessageText] = useState('');
  const [selectedFiles, setSelectedFiles] = useState([]);
  const [isSending, setIsSending] = useState(false);
  const messagesContainerRef = useRef(null);
  const messageInputRef = useRef(null);
  const fileInputRef = useRef(null);
  
  // Auto-scroll to bottom on new messages
  useEffect(() => {
    if (messagesContainerRef.current) {
      scrollToBottom();
    }
  }, [messages]);
  
  // Handle textarea auto-resize
  useEffect(() => {
    if (messageInputRef.current) {
      messageInputRef.current.style.height = 'auto';
      messageInputRef.current.style.height = 
        Math.min(messageInputRef.current.scrollHeight, 150) + 'px';
      
      if (messageInputRef.current.scrollHeight > 150) {
        messageInputRef.current.style.overflowY = 'auto';
      } else {
        messageInputRef.current.style.overflowY = 'hidden';
      }
    }
  }, [messageText]);
  
  // Mark messages as read when conversation becomes visible
  useEffect(() => {
    if (currentConversation && messages.length > 0) {
      onMarkAsRead();
    }
  }, [currentConversation, messages]);
  
  const scrollToBottom = () => {
    if (messagesContainerRef.current) {
      messagesContainerRef.current.scrollTop = messagesContainerRef.current.scrollHeight;
    }
  };
  
  const handleSendMessage = async (e) => {
    e.preventDefault();
    
    if (isSending || (!messageText.trim() && selectedFiles.length === 0) || !currentConversation) {
      return;
    }
    
    setIsSending(true);
    
    try {
      await onSendMessage(messageText, selectedFiles);
      setMessageText('');
      setSelectedFiles([]);
      scrollToBottom();
    } catch (error) {
      console.error('Error sending message:', error);
    } finally {
      setIsSending(false);
    }
  };
  
  const handleFileSelection = (e) => {
    if (e.target.files) {
      setSelectedFiles([...selectedFiles, ...Array.from(e.target.files)]);
    }
  };
  
  const removeFile = (index) => {
    setSelectedFiles(prev => prev.filter((_, i) => i !== index));
  };
  
  const clearAllFiles = () => {
    setSelectedFiles([]);
    if (fileInputRef.current) {
      fileInputRef.current.value = '';
    }
  };
  
  // Group messages by date
  const groupMessagesByDate = () => {
    const groups = {};
    
    messages.forEach(msg => {
      const date = new Date(msg.created_at).toLocaleDateString();
      if (!groups[date]) {
        groups[date] = [];
      }
      groups[date].push(msg);
    });
    
    return groups;
  };
  
  // Format date for display
  const formatMessageDate = (date) => {
    const today = new Date().toLocaleDateString();
    const yesterday = new Date(Date.now() - 86400000).toLocaleDateString();
    
    if (date === today) return 'Today';
    if (date === yesterday) return 'Yesterday';
    
    return new Date(date).toLocaleDateString('en-US', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });
  };
  
  // Get file icon based on mime type
  const getFileIcon = (mimeType) => {
    if (!mimeType) return 'fas fa-file';
    if (mimeType.startsWith('image/')) return 'fas fa-file-image';
    if (mimeType.startsWith('video/')) return 'fas fa-file-video';
    if (mimeType.startsWith('audio/')) return 'fas fa-file-audio';
    if (mimeType === 'application/pdf') return 'fas fa-file-pdf';
    if (mimeType.includes('word')) return 'fas fa-file-word';
    if (mimeType.includes('excel')) return 'fas fa-file-excel';
    if (mimeType.includes('powerpoint')) return 'fas fa-file-powerpoint';
    if (mimeType.startsWith('text/')) return 'fas fa-file-alt';
    if (mimeType.includes('zip') || mimeType.includes('rar')) return 'fas fa-file-archive';
    return 'fas fa-file';
  };
  
  // Render conversation header
  const renderConversationHeader = () => {
    if (!currentConversation || !currentConversation.other_participant) return null;
    
    const otherUser = currentConversation.other_participant;
    const initials = `${otherUser.first_name?.[0] || ''}${otherUser.last_name?.[0] || ''}`.toUpperCase();
    
    const getRoleBadgeClass = (roleId) => {
      if (roleId === 1) return 'bg-warning';
      if (roleId === 2) return 'bg-primary';
      return 'bg-secondary';
    };
    
    const getRoleName = (roleId) => {
      if (roleId === 1) return 'Admin';
      if (roleId === 2) return 'Mentor';
      return 'Intern';
    };
    
    return (
      <div className="chat-header">
        <div className="d-flex align-items-center">
          <div className="chat-avatar">
            <div className={`avatar-placeholder ${getRoleBadgeClass(otherUser.role_id)} text-white`}>
              {initials}
            </div>
            <span 
              id="otherUserStatus"
              className={`status-indicator ${otherUser.online_status || 'offline'}`}
              data-user-id={otherUser.id}
            ></span>
          </div>
          <div className="ms-2">
            <h6 className="mb-0" id="conversationName">
              {otherUser.first_name} {otherUser.last_name}
            </h6>
            <p className="text-muted small mb-0">
              <span id="userStatusText">
                {otherUser.online_status ? otherUser.online_status.charAt(0).toUpperCase() + otherUser.online_status.slice(1) : 'Offline'}
              </span>
              <span className={`ms-2 badge ${getRoleBadgeClass(otherUser.role_id)}`}>
                {getRoleName(otherUser.role_id)}
              </span>
            </p>
          </div>
        </div>
      </div>
    );
  };
  
  // Render message
  const renderMessage = (message) => {
    const isOutgoing = message.sender.id === currentUser.id;
    const getInitials = (name) => {
      return (name || '').split(' ').map(p => p[0]).join('').substring(0, 2).toUpperCase();
    };
    
    return (
      <div key={message.id} className={`message-item ${isOutgoing ? 'outgoing' : ''}`} data-message-id={message.id}>
        <div className="message-avatar">
          <div className={`avatar-placeholder ${isOutgoing ? 'bg-primary' : 'bg-secondary'} text-white`}>
            {getInitials(message.sender.name)}
          </div>
        </div>
        <div className="message-content">
          <div className="message-header">
            <span className="message-sender">{message.sender.name}</span>
            <span className="message-time">{message.formatted_time}</span>
          </div>
          
          {message.message && (
            <div className="message-bubble">
              <p className="message-text mb-0">{message.message}</p>
            </div>
          )}
          
          {message.attachments && message.attachments.length > 0 && (
            <div className="message-attachments">
              {message.attachments.map(attachment => (
                attachment.is_image ? (
                  <div key={attachment.id} className="image-attachment">
                    <img 
                      src={attachment.url} 
                      alt={attachment.file_name}
                      className="img-fluid rounded"
                    />
                    <a 
                      href={`/chat/attachments/${attachment.id}/download`}
                      className="attachment-download" 
                      title="Download"
                    >
                      <i className="fas fa-download"></i>
                    </a>
                  </div>
                ) : (
                  <div key={attachment.id} className="attachment-item">
                    <div className="attachment-preview">
                      <i className={getFileIcon(attachment.file_type)}></i>
                    </div>
                    <div className="attachment-info">
                      <div className="attachment-name">{attachment.file_name}</div>
                      <div className="attachment-meta">
                        <span className="attachment-size">{attachment.file_size}</span>
                      </div>
                    </div>
                    <a 
                      href={`/chat/attachments/${attachment.id}/download`}
                      className="attachment-download" 
                      title="Download"
                    >
                      <i className="fas fa-download"></i>
                    </a>
                  </div>
                )
              ))}
            </div>
          )}
          
          {isOutgoing && (
            <div className="message-status">
              {message.failed ? (
                <span className="status-text text-danger">
                  <i className="fas fa-exclamation-circle"></i> Failed
                </span>
              ) : (
                <span className="status-text">
                  <i className={`fas fa-check${message.is_read ? '-double' : ''}`}></i> 
                  {message.is_read ? 'Read' : 'Delivered'}
                </span>
              )}
            </div>
          )}
        </div>
      </div>
    );
  };
  
  // Render file previews
  const renderFilePreview = () => {
    if (selectedFiles.length === 0) return null;
    
    return (
      <div id="attachmentPreview" className="p-2 border-top">
        <div className="d-flex justify-content-between align-items-center mb-2">
          <span className="fw-medium">Attachments</span>
          <button 
            type="button" 
            className="btn btn-sm btn-link text-danger"
            onClick={clearAllFiles}
          >
            Clear all
          </button>
        </div>
        <div id="attachmentFiles" className="d-flex flex-wrap gap-2">
          {selectedFiles.map((file, index) => (
            <div key={index} className="attachment-preview-item">
              <div className="attachment-preview-content">
                <i className={getFileIcon(file.type)}></i>
                <span className="attachment-preview-name">{file.name}</span>
              </div>
              <button 
                type="button" 
                className="btn btn-sm btn-link text-danger remove-attachment"
                onClick={() => removeFile(index)}
              >
                <i className="fas fa-times"></i>
              </button>
            </div>
          ))}
        </div>
      </div>
    );
  };
  
  // Render empty state
  const renderEmptyState = () => {
    return (
      <div className="chat-empty text-center">
        <div className="empty-illustration mb-4">
          <i className="fas fa-comment-dots"></i>
        </div>
        <h4>Select a conversation</h4>
        <p className="text-muted">Choose a conversation from the list or start a new one</p>
        {contacts && contacts.length > 0 && (
          <div className="mt-4">
            {currentUser.role_id === 3 && contacts.find(c => c.role_id === 2) ? (
              <button 
                className="btn btn-primary" 
                onClick={() => {
                  const mentor = contacts.find(c => c.role_id === 2);
                  if (mentor) onSendMessage(mentor.id);
                }}
              >
                <i className="fas fa-comment-medical me-2"></i> Message Your Mentor
              </button>
            ) : (
              <div className="dropdown">
                <button 
                  className="btn btn-primary dropdown-toggle" 
                  type="button"
                  id="emptyStateDropdown" 
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i className="fas fa-plus me-2"></i> Start New Conversation
                </button>
                <ul className="dropdown-menu" aria-labelledby="emptyStateDropdown">
                  {contacts.map(contact => (
                    <li key={contact.id}>
                      <a 
                        className="dropdown-item d-flex align-items-center"
                        href="#"
                        onClick={(e) => {
                          e.preventDefault();
                          onSendMessage(contact.id);
                        }}
                      >
                        <div className="chat-avatar me-2" style={{ width: '25px', height: '25px' }}>
                          <div 
                            className={`avatar-placeholder ${contact.role_id === 2 ? 'bg-primary' : (contact.role_id === 1 ? 'bg-warning' : 'bg-secondary')} text-white`}
                            style={{ width: '20px', height: '20px', fontSize: '10px' }}
                          >
                            {`${contact.first_name?.[0] || ''}${contact.last_name?.[0] || ''}`.toUpperCase()}
                          </div>
                        </div>
                        <span>{contact.first_name} {contact.last_name}</span>
                        <span className={`ms-auto badge ${contact.role_id === 2 ? 'bg-primary' : (contact.role_id === 1 ? 'bg-warning' : 'bg-secondary')}`}>
                          {contact.role_id === 1 ? 'Admin' : (contact.role_id === 2 ? 'Mentor' : 'Intern')}
                        </span>
                      </a>
                    </li>
                  ))}
                </ul>
              </div>
            )}
          </div>
        )}
      </div>
    );
  };
  
  // Render loading indicator
  const renderLoadingState = () => (
    <div className="messages-loading text-center py-5">
      <div className="spinner-border text-primary" role="status">
        <span className="visually-hidden">Loading...</span>
      </div>
      <p className="mt-2">Loading messages...</p>
    </div>
  );
  
  return (
    <div className="chat-main">
      {currentConversation ? (
        <>
          {renderConversationHeader()}
          
          <div className="chat-messages" id="chatMessages" ref={messagesContainerRef}>
            {isLoading ? (
              renderLoadingState()
            ) : (
              Object.entries(groupMessagesByDate()).map(([date, msgs]) => (
                <React.Fragment key={date}>
                  <div className="message-date-divider">
                    <span className="message-date">{formatMessageDate(date)}</span>
                  </div>
                  {msgs.map(message => renderMessage(message))}
                </React.Fragment>
              ))
            )}
          </div>
          
          <div className="chat-input">
            <form id="messageForm" encType="multipart/form-data" onSubmit={handleSendMessage}>
              <div className="input-group">
                <button 
                  type="button" 
                  className="btn btn-light border-0" 
                  id="attachmentBtn"
                  onClick={() => fileInputRef.current?.click()}
                >
                  <i className="fas fa-paperclip"></i>
                </button>
                <input 
                  type="file" 
                  id="attachmentInput"
                  ref={fileInputRef}
                  multiple 
                  style={{ display: 'none' }}
                  onChange={handleFileSelection}
                />
                <textarea 
                  className="form-control border-0" 
                  id="messageInput"
                  ref={messageInputRef}
                  rows="1" 
                  placeholder="Type a message..."
                  value={messageText}
                  onChange={(e) => setMessageText(e.target.value)}
                />
                <button 
                  type="submit" 
                  className="btn btn-primary"
                  disabled={isSending}
                >
                  {isSending ? (
                    <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  ) : (
                    <i className="fas fa-paper-plane"></i>
                  )}
                </button>
              </div>
              {renderFilePreview()}
            </form>
          </div>
        </>
      ) : (
        renderEmptyState()
      )}
    </div>
  );
}