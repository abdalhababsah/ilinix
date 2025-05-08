{{-- resources/views/chat/index.blade.php --}}
@extends('dashboard-layout.app')

@section('content')
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @push('styles')
        <link rel="stylesheet" href="{{ asset('dashboard-assets/css/chat.css') }}">
    @endpush
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-card mb-4">
                    <div class="card-body p-0">
                        <div class="chat-container">
                            <div class="chat-sidebar">
                                <!-- User Profile -->
                                <div class="chat-user-profile p-3 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="chat-avatar">
                                            <div class="avatar-placeholder bg-primary text-white">
                                                {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}
                                            </div>
                                            <span
                                                class="status-indicator {{ Auth::user()->onlineStatus && Auth::user()->onlineStatus->status === 'online' ? 'online' : 'offline' }}"
                                                data-user-id="{{ Auth::user()->id }}"></span>
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                            </h6>
                                            <div class="text-muted small">
                                                <select id="userStatus" class="form-select form-select-sm status-select">
                                                    <option value="online"
                                                        {{ optional(Auth::user()->onlineStatus)->status === 'online' ? 'selected' : '' }}>
                                                        Online</option>
                                                    <option value="away"
                                                        {{ optional(Auth::user()->onlineStatus)->status === 'away' ? 'selected' : '' }}>
                                                        Away</option>
                                                    <option value="offline"
                                                        {{ optional(Auth::user()->onlineStatus)->status === 'offline' ? 'selected' : '' }}>
                                                        Offline</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Button for New Messages -->
                                @if (isset($contacts) && count($contacts) > 0)
                                    <div class="p-3 border-bottom">
                                        <div class="dropdown w-100">
                                            <button class="btn btn-primary btn-sm w-100 dropdown-toggle" type="button"
                                                id="newMessageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-plus me-2"></i> New Message
                                            </button>
                                            <ul class="dropdown-menu w-100" aria-labelledby="newMessageDropdown">
                                                @foreach ($contacts as $contact)
                                                    <li>
                                                        <a class="dropdown-item start-chat-btn d-flex align-items-center"
                                                            href="#" data-user-id="{{ $contact->id }}">
                                                            <div class="chat-avatar me-2"
                                                                style="width: 25px; height: 25px;">
                                                                <div class="avatar-placeholder 
                                                                {{ $contact->role_id == 2 ? 'bg-primary' : ($contact->role_id == 1 ? 'bg-warning' : 'bg-secondary') }} 
                                                                text-white"
                                                                    style="width: 20px; height: 20px; font-size: 10px;">
                                                                    {{ substr($contact->first_name, 0, 1) }}{{ substr($contact->last_name, 0, 1) }}
                                                                </div>
                                                            </div>
                                                            <span>{{ $contact->first_name }}
                                                                {{ $contact->last_name }}</span>
                                                            <span
                                                                class="ms-auto badge 
                                                            {{ $contact->role_id == 2 ? 'bg-primary' : ($contact->role_id == 1 ? 'bg-warning' : 'bg-secondary') }}">
                                                                {{ $contact->role_id == 1 ? 'Admin' : ($contact->role_id == 2 ? 'Mentor' : 'Intern') }}
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                <div class="chat-search p-3 border-bottom">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" id="conversationSearch" class="form-control border-0 bg-light"
                                            placeholder="Search conversations...">
                                    </div>
                                </div>
                                <div class="conversation-list">
                                    @if (isset($conversations) && $conversations->count())
                                        @foreach ($conversations as $conversation)
                                            @php
                                                $otherUser = $conversation->participants->first();
                                                $unreadCount = $conversation->unreadMessagesCount(Auth::id());
                                                $lastMessage = $conversation->latestMessage;
                                                $isActive =
                                                    isset($activeConversation) &&
                                                    $activeConversation->id === $conversation->id;
                                            @endphp
                                            <div class="conversation-item {{ $isActive ? 'active' : '' }}"
                                                data-conversation-id="{{ $conversation->id }}">
                                                <div class="chat-avatar">
                                                    <div
                                                        class="avatar-placeholder {{ $otherUser->role_id == 2 ? 'bg-primary' : ($otherUser->role_id == 1 ? 'bg-warning' : 'bg-secondary') }} text-white">
                                                        {{ substr($otherUser->first_name, 0, 1) }}{{ substr($otherUser->last_name, 0, 1) }}
                                                    </div>
                                                    <span
                                                        class="status-indicator
                                                    {{ optional($otherUser->onlineStatus)->status === 'online' ? 'online' : 'offline' }}"
                                                        data-user-id="{{ $otherUser->id }}"></span>
                                                </div>
                                                <div class="conversation-info">
                                                    <h6 class="mb-1 conversation-name">
                                                        {{ $otherUser->first_name . ' ' . $otherUser->last_name }}</h6>
                                                    <p class="text-muted mb-0 last-message">
                                                        @if ($lastMessage)
                                                            @if ($lastMessage->hasAttachments() && !$lastMessage->message)
                                                                <i class="fas fa-paperclip me-1"></i> Attachment
                                                            @else
                                                                {{ Str::limit($lastMessage->message, 30) }}
                                                            @endif
                                                        @else
                                                            Start a conversation
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="conversation-meta">
                                                    @if ($lastMessage)
                                                        <span class="message-time">
                                                            {{ $lastMessage->created_at->isToday()
                                                                ? $lastMessage->created_at->format('g:i A')
                                                                : $lastMessage->created_at->format('M d') }}
                                                        </span>
                                                    @endif
                                                    @if ($unreadCount)
                                                        <span class="unread-badge">{{ $unreadCount }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-5">
                                            <div class="empty-state-icon mb-3"><i class="fas fa-comments text-muted"></i>
                                            </div>
                                            <h6 class="text-muted">No conversations yet</h6>
                                            <p class="small text-muted">
                                                @if (Auth::user()->isIntern())
                                                    Messages with your mentor will appear here
                                                @elseif (Auth::user()->isMentor())
                                                    Messages with your interns will appear here
                                                @else
                                                    Messages with mentors and interns will appear here
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="chat-main">
                                @if (isset($activeConversation))
                                    @php($otherUser = $activeConversation->participants->first())
                                    <!-- Chat Header -->
                                    <div class="chat-header">
                                        <div class="d-flex align-items-center">
                                            <div class="chat-avatar">
                                                <div
                                                    class="avatar-placeholder {{ $otherUser->role_id == 2 ? 'bg-primary' : ($otherUser->role_id == 1 ? 'bg-warning' : 'bg-secondary') }} text-white">
                                                    {{ substr($otherUser->first_name, 0, 1) }}{{ substr($otherUser->last_name, 0, 1) }}
                                                </div>
                                                <span id="otherUserStatus"
                                                    class="status-indicator {{ optional($otherUser->onlineStatus)->status === 'online' ? 'online' : 'offline' }}"
                                                    data-user-id="{{ $otherUser->id }}"></span>
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-0" id="conversationName">
                                                    {{ $otherUser->first_name . ' ' . $otherUser->last_name }}</h6>
                                                <p class="text-muted small mb-0">
                                                    <span id="userStatusText">
                                                        {{ optional($otherUser->onlineStatus)->status ? ucfirst(optional($otherUser->onlineStatus)->status) : 'Offline' }}
                                                    </span>
                                                    @if ($otherUser->role_id == 1)
                                                        <span class="ms-2 badge bg-warning">Admin</span>
                                                    @elseif ($otherUser->role_id == 2)
                                                        <span class="ms-2 badge bg-primary">Mentor</span>
                                                    @elseif ($otherUser->role_id == 3)
                                                        <span class="ms-2 badge bg-secondary">Intern</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Chat Messages -->
                                    <div class="chat-messages" id="chatMessages">
                                        <div class="messages-loading text-center py-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-2">Loading messages...</p>
                                        </div>
                                    </div>

                                    <!-- Chat Input -->
                                    <div class="chat-input">
                                        <form id="messageForm" enctype="multipart/form-data">
                                            <input type="hidden" id="conversationId"
                                                value="{{ $activeConversation->id }}">
                                            <div class="input-group">
                                                <button type="button" class="btn btn-light border-0" id="attachmentBtn">
                                                    <i class="fas fa-paperclip"></i>
                                                </button>
                                                <input type="file" id="attachmentInput" multiple style="display:none">
                                                <textarea class="form-control border-0" id="messageInput" rows="1" placeholder="Type a message..."></textarea>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                            <div id="attachmentPreview" class="d-none p-2 border-top">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="fw-medium">Attachments</span>
                                                    <button type="button" class="btn btn-sm btn-link text-danger"
                                                        id="clearAttachments">Clear all</button>
                                                </div>
                                                <div id="attachmentFiles" class="d-flex flex-wrap gap-2"></div>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <!-- Empty State -->
                                    <div class="chat-empty text-center">
                                        <div class="empty-illustration mb-4"><i class="fas fa-comment-dots"></i></div>
                                        <h4>Select a conversation</h4>
                                        <p class="text-muted">Choose a conversation from the list or start a new one</p>
                                        @if (isset($contacts) && count($contacts) > 0)
                                            <div class="mt-4">
                                                @if (Auth::user()->isIntern() && $contacts->first() && $contacts->first()->isMentor())
                                                    <button class="btn btn-primary start-chat-btn"
                                                        data-user-id="{{ $contacts->first()->id }}">
                                                        <i class="fas fa-comment-medical me-2"></i> Message Your Mentor
                                                    </button>
                                                @else
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                            id="emptyStateDropdown" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="fas fa-plus me-2"></i> Start New Conversation
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="emptyStateDropdown">
                                                            @foreach ($contacts as $contact)
                                                                <li>
                                                                    <a class="dropdown-item start-chat-btn d-flex align-items-center"
                                                                        href="#"
                                                                        data-user-id="{{ $contact->id }}">
                                                                        <div class="chat-avatar me-2"
                                                                            style="width: 25px; height: 25px;">
                                                                            <div class="avatar-placeholder 
                                                                                {{ $contact->role_id == 2 ? 'bg-primary' : ($contact->role_id == 1 ? 'bg-warning' : 'bg-secondary') }} 
                                                                                text-white"
                                                                                style="width: 20px; height: 20px; font-size: 10px;">
                                                                                {{ substr($contact->first_name, 0, 1) }}{{ substr($contact->last_name, 0, 1) }}
                                                                            </div>
                                                                        </div>
                                                                        <span>{{ $contact->first_name }}
                                                                            {{ $contact->last_name }}</span>
                                                                        <span
                                                                            class="ms-auto badge 
                                                                            {{ $contact->role_id == 2 ? 'bg-primary' : ($contact->role_id == 1 ? 'bg-warning' : 'bg-secondary') }}">
                                                                            {{ $contact->role_id == 1 ? 'Admin' : ($contact->role_id == 2 ? 'Mentor' : 'Intern') }}
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================ TEMPLATES (hidden) ================ -->
    <template id="messageTemplate">
        <div class="message-item">
            <div class="message-avatar">
                <div class="avatar-placeholder bg-primary text-white">AA</div>
            </div>
            <div class="message-content">
                <div class="message-header">
                    <span class="message-sender">Sender Name</span>
                    <span class="message-time">12:34 PM</span>
                </div>
                <div class="message-bubble">
                    <p class="message-text mb-0">Message text goes here</p>
                </div>
                <div class="message-attachments"></div>
                <div class="message-status"><span class="status-text">Delivered</span></div>
            </div>
        </div>
    </template>

    <template id="attachmentTemplate">
        <div class="attachment-item">
            <div class="attachment-preview"><i class="fas fa-file"></i></div>
            <div class="attachment-info">
                <div class="attachment-name">filename.pdf</div>
                <div class="attachment-meta"><span class="attachment-size">123 KB</span></div>
            </div>
            <a href="#" class="attachment-download" title="Download"><i class="fas fa-download"></i></a>
        </div>
    </template>

    <template id="imageAttachmentTemplate">
        <div class="image-attachment">
            <img src="" alt="Image attachment" class="img-fluid rounded">
            <a href="#" class="attachment-download" title="Download"><i class="fas fa-download"></i></a>
        </div>
    </template>

    <template id="attachmentPreviewTemplate">
        <div class="attachment-preview-item">
            <div class="attachment-preview-content">
                <i class="fas fa-file"></i><span class="attachment-preview-name">filename.pdf</span>
            </div>
            <button type="button" class="btn btn-sm btn-link text-danger remove-attachment">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </template>
@endsection     
@push('scripts')
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /* --------------------------------------------------
             *  DOM REFS
             * -------------------------------------------------- */
            const conversationList = document.querySelector('.conversation-list');
            const chatMessages = document.getElementById('chatMessages');
            const messageForm = document.getElementById('messageForm');
            const messageInput = document.getElementById('messageInput');
            const attachmentBtn = document.getElementById('attachmentBtn');
            const attachmentInput = document.getElementById('attachmentInput');
            const attachmentPreview = document.getElementById('attachmentPreview');
            const attachmentFiles = document.getElementById('attachmentFiles');
            const clearAttachments = document.getElementById('clearAttachments');
            const searchInput = document.getElementById('conversationSearch');
            const userStatusSelect = document.getElementById('userStatus');
            const messageTpl = document.getElementById('messageTemplate');
            const attachTpl = document.getElementById('attachmentTemplate');
            const imgTpl = document.getElementById('imageAttachmentTemplate');
            const attachPrevTpl = document.getElementById('attachmentPreviewTemplate');
            const conversationIdFld = document.getElementById('conversationId');

            /* --------------------------------------------------
             *  STATE
             * -------------------------------------------------- */
            let activeConversation = conversationIdFld ? conversationIdFld.value : null;
            let selectedFiles = [];
            let isSubmitting = false; //  ----- duplicate‑send guard
            const loadedMessageIds = new Set(); //  ----- duplicate‑render guard

            /* --------------------------------------------------
             *  PUSHER INIT
             * -------------------------------------------------- */
            Pusher.logToConsole = true; // remove in prod
            const pusher = new Pusher('68e754591a83be75b54c', {
                cluster: 'ap2',
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    withCredentials: true
                }
            });

            /* --------------------------------------------------
             *  BOOTSTRAP
             * -------------------------------------------------- */
            if (activeConversation) {
                loadMessages(activeConversation);
                subscribeToConversation(activeConversation);
            }
            conversationList?.querySelectorAll('.conversation-item').forEach(item => {
                const id = item.dataset.conversationId;
                if (id && id !== activeConversation) subscribeToConversation(id, true);
            });
            updateUserStatus(userStatusSelect.value);

            /* --------------------------------------------------
             *  LOAD MESSAGES
             * -------------------------------------------------- */
            function loadMessages(cid) {
                fetch(`/chat/conversations/${cid}/messages`)
                    .then(r => r.json())
                    .then(data => {
                        chatMessages.innerHTML = '';
                        loadedMessageIds.clear();

                        const groups = groupMessagesByDate(data.messages);
                        Object.keys(groups).forEach(d => {
                            const div = document.createElement('div');
                            div.className = 'message-date-divider';
                            div.innerHTML = `<span class="message-date">${formatMessageDate(d)}</span>`;
                            chatMessages.appendChild(div);
                            groups[d].forEach(renderMessage);
                        });
                        scrollToBottom();
                        markConversationAsRead(cid);
                    })
                    .catch(err => {
                        console.error(err);
                        chatMessages.innerHTML = `<div class="text-center py-5">
                            <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>
                                Failed to load messages.</div></div>`;
                    });
            }

            /* --------------------------------------------------
             *  RENDER SINGLE MESSAGE
             * -------------------------------------------------- */
            function renderMessage(msg) {
                if (loadedMessageIds.has(msg.id)) return; // ---- skip duplicate
                loadedMessageIds.add(msg.id);

                const node = document.importNode(messageTpl.content, true);
                const wrap = node.querySelector('.message-item');
                wrap.dataset.messageId = msg.id;

                const outgoing = msg.sender.id === {{ Auth::id() }};
                if (outgoing) wrap.classList.add('outgoing');

                // avatar/name/time
                wrap.querySelector('.avatar-placeholder').textContent = getInitials(msg.sender.name);
                wrap.querySelector('.message-sender').textContent = msg.sender.name;
                wrap.querySelector('.message-time').textContent = msg.formatted_time;

                // text
                if (msg.message) wrap.querySelector('.message-text').textContent = msg.message;
                else wrap.querySelector('.message-bubble').style.display = 'none';

                // attachments
                if (msg.attachments?.length) {
                    const holder = wrap.querySelector('.message-attachments');
                    msg.attachments.forEach(att => {
                        if (att.is_image) {
                            const n = document.importNode(imgTpl.content, true);
                            n.querySelector('img').src = att.url;
                            n.querySelector('img').alt = att.file_name;
                            n.querySelector('.attachment-download').href =
                                `/chat/attachments/${att.id}/download`;
                            holder.appendChild(n);
                        } else {
                            const n = document.importNode(attachTpl.content, true);
                            n.querySelector('.attachment-preview i').className = getFileIcon(att.file_type);
                            n.querySelector('.attachment-name').textContent = att.file_name;
                            n.querySelector('.attachment-size').textContent = att.file_size;
                            n.querySelector('.attachment-download').href =
                                `/chat/attachments/${att.id}/download`;
                            holder.appendChild(n);
                        }
                    });
                }

                // status
                const st = wrap.querySelector('.message-status');
                if (outgoing) {
                    st.innerHTML =
                        `<span class="status-text"><i class="fas fa-check${msg.is_read?'-double':''}"></i> ${msg.is_read?'Read':'Delivered'}</span>`;
                } else st.style.display = 'none';

                chatMessages.appendChild(wrap);
            }

            /* --------------------------------------------------
             *  SUBSCRIBE TO CHANNEL
             * -------------------------------------------------- */
            function subscribeToConversation(id, notifyOnly = false) {
                const ch = pusher.subscribe(`private-chat.${id}`);
                ch.bind('new.message', data => {
                    if (notifyOnly) {
                        updateConversationUnreadBadge(id);
                        updateConversationLastMessage(id, data);
                    } else if (id === activeConversation) {
                        renderMessage(data);
                        scrollToBottom();
                        markConversationAsRead(id);
                    }
                });
                ch.bind('messages.read', d => {
                    if (id === activeConversation) updateMessageReadStatus(d.user_id, d.read_at);
                });
            }

            /* --------------------------------------------------
             *  SEND MESSAGE
             * -------------------------------------------------- */
            function sendMessage() {
                if (isSubmitting) return;
                if ((!messageInput.value.trim() && !selectedFiles.length) || !activeConversation) return;

                isSubmitting = true;
                const btn = messageForm.querySelector('button[type="submit"]');
                btn.disabled = true;

                const fd = new FormData();
                fd.append('conversation_id', activeConversation);
                fd.append('message', messageInput.value.trim());
                selectedFiles.forEach((f, i) => fd.append(`attachments[${i}]`, f));

                // optimistic
                const tmpId = `tmp-${Date.now()}`;
                renderMessage({
                    id: tmpId,
                    conversation_id: activeConversation,
                    message: messageInput.value.trim(),
                    created_at: new Date(),
                    formatted_time: new Date().toLocaleTimeString([], {
                        hour: 'numeric',
                        minute: '2-digit'
                    }),
                    formatted_date: new Date().toLocaleDateString(),
                    is_read: false,
                    sender: {
                        id: {{ Auth::id() }},
                        name: '{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}',
                        role_id: {{ Auth::user()->role_id }}
                    },
                    attachments: []
                });
                scrollToBottom();
                messageInput.value = '';
                clearAttachmentPreview();

                fetch('/chat/messages', {
                        method: 'POST',
                        body: fd,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(r => r.json())
                    .then(d => {
                        chatMessages.querySelector(`[data-message-id="${tmpId}"]`)?.remove();
                        renderMessage(d.message);
                        scrollToBottom();
                        updateConversationLastMessage(activeConversation, d.message);
                    })
                    .catch(err => {
                        console.error(err);
                        const wrap = chatMessages.querySelector(`[data-message-id="${tmpId}"]`);
                        if (wrap) {
                            wrap.querySelector('.status-text').innerHTML =
                                '<i class="fas fa-exclamation-circle text-danger"></i> Failed';
                        }
                    })
                    .finally(() => {
                        isSubmitting = false;
                        btn.disabled = false;
                    });
            }

            /* --------------------------------------------------
             *  ATTACHMENT PREVIEW
             * -------------------------------------------------- */
            function handleAttachmentPreview() {
                attachmentFiles.innerHTML = '';
                if (!selectedFiles.length) {
                    attachmentPreview.classList.add('d-none');
                    return;
                }
                attachmentPreview.classList.remove('d-none');
                selectedFiles.forEach((f, i) => {
                    const n = document.importNode(attachPrevTpl.content, true);
                    n.querySelector('i').className = getFileIcon(f.type);
                    n.querySelector('.attachment-preview-name').textContent = f.name;
                    n.querySelector('.remove-attachment').addEventListener('click', () => {
                        selectedFiles.splice(i, 1);
                        handleAttachmentPreview();
                    });
                    attachmentFiles.appendChild(n);
                });
            }

            function clearAttachmentPreview() {
                selectedFiles = [];
                handleAttachmentPreview();
                attachmentInput.value = '';
            }

            /* --------------------------------------------------
             *  EVENT BINDINGS
             * -------------------------------------------------- */
            messageForm?.addEventListener('submit', e => {
                e.preventDefault();
                sendMessage();
            });
            attachmentBtn?.addEventListener('click', () => attachmentInput.click());
            attachmentInput?.addEventListener('change', function() {
                [...this.files].forEach(f => selectedFiles.push(f));
                handleAttachmentPreview();
            });
            clearAttachments?.addEventListener('click', clearAttachmentPreview);
            conversationList?.addEventListener('click', e => {
                const item = e.target.closest('.conversation-item');
                if (!item) return;
                document.querySelectorAll('.conversation-item').forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                activeConversation = item.dataset.conversationId;
                loadMessages(activeConversation);
                history.pushState({}, '', `/chat?conversation=${activeConversation}`);
            });
            searchInput?.addEventListener('input', function() {
                const q = this.value.toLowerCase();
                conversationList.querySelectorAll('.conversation-item').forEach(i => {
                    const n = i.querySelector('.conversation-name').textContent.toLowerCase();
                    const l = i.querySelector('.last-message').textContent.toLowerCase();
                    i.style.display = (n.includes(q) || l.includes(q)) ? 'flex' : 'none';
                });
            });
            userStatusSelect?.addEventListener('change', () => updateUserStatus(userStatusSelect.value));

            document.querySelectorAll('.start-chat-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    fetch('/chat/conversations', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                user_id: btn.dataset.userId
                            })
                        })
                        .then(r => r.json())
                        .then(d => location.href = `/chat?conversation=${d.conversation_id}`)
                        .catch(() => alert('Failed to start conversation'));
                });
            });

            messageInput?.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
                if (this.scrollHeight > 150) {
                    this.style.overflowY = 'auto';
                    this.style.height = '150px';
                } else this.style.overflowY = 'hidden';
            });

            /* --------------------------------------------------
             *  VISIBILITY / UNLOAD
             * -------------------------------------------------- */
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    setTimeout(() => {
                        if (document.hidden && userStatusSelect.value === 'online') {
                            userStatusSelect.value = 'away';
                            updateUserStatus('away');
                        }
                    }, 60000);
                } else if (userStatusSelect.value === 'away') {
                    userStatusSelect.value = 'online';
                    updateUserStatus('online');
                }
            });
            window.addEventListener('beforeunload', () => {
                if (navigator.sendBeacon) {
                    const fd = new FormData();
                    fd.append('status', 'offline');
                    fd.append('_token', '{{ csrf_token() }}');
                    navigator.sendBeacon('/chat/status', fd);
                } else updateUserStatus('offline');
            });

            /* --------------------------------------------------
             *  UTILITIES
             * -------------------------------------------------- */
            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function groupMessagesByDate(arr) {
                const g = {};
                arr.forEach(m => {
                    const d = new Date(m.created_at).toLocaleDateString();
                    (g[d] = g[d] || []).push(m);
                });
                return g;
            }

            function formatMessageDate(d) {
                const t = new Date(),
                    y = new Date();
                y.setDate(t.getDate() - 1);
                const dt = new Date(d);
                if (dt.toDateString() === t.toDateString()) return 'Today';
                if (dt.toDateString() === y.toDateString()) return 'Yesterday';
                return dt.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }

            function getInitials(n) {
                return (n || '').split(' ').map(p => p[0]).join('').substr(0, 2).toUpperCase();
            }

            function getFileIcon(t) {
                if (t.startsWith('image/')) return 'fas fa-file-image';
                if (t.startsWith('video/')) return 'fas fa-file-video';
                if (t.startsWith('audio/')) return 'fas fa-file-audio';
                if (t === 'application/pdf') return 'fas fa-file-pdf';
                if (t.includes('word')) return 'fas fa-file-word';
                if (t.includes('excel')) return 'fas fa-file-excel';
                if (t.includes('powerpoint')) return 'fas fa-file-powerpoint';
                if (t.startsWith('text/')) return 'fas fa-file-alt';
                if (t.includes('zip') || t.includes('rar')) return 'fas fa-file-archive';
                return 'fas fa-file';
            }

            function markConversationAsRead(id) {
                fetch('/chat/conversations/read', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            conversation_id: id
                        })
                    })
                    .then(r => r.json()).then(d => {
                        if (d.success) {
                            conversationList.querySelector(`[data-conversation-id="${id}"] .unread-badge`)
                                ?.remove();
                        }
                    }).catch(console.error);
            }

            function updateConversationUnreadBadge(id) {
                const item = conversationList.querySelector(`[data-conversation-id="${id}"]`);
                if (!item) return;
                let badge = item.querySelector('.unread-badge');
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'unread-badge';
                    badge.textContent = '1';
                    item.querySelector('.conversation-meta').appendChild(badge);
                } else badge.textContent = parseInt(badge.textContent) + 1;
                conversationList.prepend(item);
            }

            function updateConversationLastMessage(id, msg) {
                const item = conversationList.querySelector(`[data-conversation-id="${id}"]`);
                if (!item) return;
                const last = item.querySelector('.last-message');
                const time = item.querySelector('.message-time');
                if (last) {
                    if (msg.message?.trim()) last.textContent = msg.message.length > 30 ? msg.message.substr(0,
                        30) + '…' : msg.message;
                    else if (msg.attachments?.length) last.innerHTML =
                        '<i class="fas fa-paperclip me-1"></i> Attachment';
                }
                time && (time.textContent = msg.formatted_time);
                conversationList.prepend(item);
            }

            function updateMessageReadStatus(uid, readAt) {
                if (uid === {{ Auth::id() }}) return;
                chatMessages.querySelectorAll('.message-item.outgoing .status-text').forEach(el => {
                    el.innerHTML = '<i class="fas fa-check-double"></i> Read';
                });
            }

            function updateUserStatus(status) {
                fetch('/chat/status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status
                        })
                    })
                    .then(r => r.json()).catch(console.error);
            }

            /* --------------------------------------------------
             *  LIVE USER‑STATUS UPDATES
             * -------------------------------------------------- */
            const userStatusChannel = pusher.subscribe('private-user-status');
            /**
             * Update every status pill + (if visible) the header text
             */
            function paintStatus(userId, newStatus) {
                document.querySelectorAll(`.status-indicator[data-user-id="${userId}"]`)
                    .forEach(dot => {
                        dot.classList.remove('online', 'away', 'offline');
                        dot.classList.add(newStatus);
                    });

                const headerDot = document.getElementById('otherUserStatus');
                if (headerDot && +headerDot.dataset.userId === +userId) {
                    const txt = document.getElementById('userStatusText');
                    if (txt) txt.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                }
            }

            /* Laravel default (class name) */
            userStatusChannel.bind('UserStatusChanged', data =>
                paintStatus(data.user_id ?? data.id, data.status)
            );

            /* Custom alias broadcastAs('user.status') */
            userStatusChannel.bind('user.status', data =>
                paintStatus(data.user_id ?? data.id, data.status)
            );


        });
    </script>
@endpush
