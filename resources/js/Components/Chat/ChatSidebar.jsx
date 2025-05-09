import React, { useState, useEffect } from 'react';

export default function ChatSidebar({ 
 conversations, 
 contacts, 
 currentUser, 
 activeConversationId, 
 userStatus, 
 onStatusChange, 
 onConversationSelect, 
 onStartNewConversation 
}) {
 const [searchQuery, setSearchQuery] = useState('');
 const [filteredConversations, setFilteredConversations] = useState(conversations || []);
 
 useEffect(() => {
   if (!conversations) return;
   
   if (searchQuery.trim() === '') {
     setFilteredConversations(conversations);
   } else {
     const query = searchQuery.toLowerCase();
     setFilteredConversations(conversations.filter(conv => {
       const otherParticipant = conv.participants?.[0];
       if (!otherParticipant) return false;
       
       const name = `${otherParticipant.first_name} ${otherParticipant.last_name}`.toLowerCase();
       const lastMessage = conv.latest_message?.message?.toLowerCase() || '';
       
       return name.includes(query) || lastMessage.includes(query);
     }));
   }
 }, [conversations, searchQuery]);
 
 const handleStatusChange = (e) => {
   onStatusChange(e.target.value);
 };
 
 const handleSearch = (e) => {
   setSearchQuery(e.target.value);
 };
 
 const handleConversationClick = (conversation) => {
   onConversationSelect(conversation);
 };
 
 const handleStartChat = (contact) => {
   onStartNewConversation(contact.id);
 };
 
 // Helper function to get user initials
 const getInitials = (name) => {
   if (!name) return '??';
   return name.split(' ')
     .map(part => part[0])
     .join('')
     .toUpperCase()
     .substring(0, 2);
 };
 
 // Determine role badge class
 const getRoleBadgeClass = (roleId) => {
   if (roleId === 1) return 'bg-warning';
   if (roleId === 2) return 'bg-primary';
   return 'bg-secondary';
 };
 
 // Get role name
 const getRoleName = (roleId) => {
   if (roleId === 1) return 'Admin';
   if (roleId === 2) return 'Mentor';
   return 'Intern';
 };
 
 return (
   <div className="chat-sidebar">
     {/* User Profile */}
     <div className="chat-user-profile p-3 border-bottom">
       <div className="d-flex align-items-center">
         <div className="chat-avatar">
           <div className="avatar-placeholder bg-primary text-white">
             {getInitials(`${currentUser?.first_name} ${currentUser?.last_name}`)}
           </div>
           <span className={`status-indicator ${userStatus}`} data-user-id={currentUser?.id}></span>
         </div>
         <div className="ms-2">
           <h6 className="mb-0">{currentUser?.first_name} {currentUser?.last_name}</h6>
           <div className="text-muted small">
             <select 
               id="userStatus"
               className="form-select form-select-sm status-select" 
               value={userStatus}
               onChange={handleStatusChange}
             >
               <option value="online">Online</option>
               <option value="away">Away</option>
               <option value="offline">Offline</option>
             </select>
           </div>
         </div>
       </div>
     </div>

     {/* Contact Button for New Messages */}
     {contacts && contacts.length > 0 && (
       <div className="p-3 border-bottom">
         <div className="dropdown w-100">
           <button 
             className="btn btn-primary btn-sm w-100 dropdown-toggle" 
             type="button"
             id="newMessageDropdown" 
             data-bs-toggle="dropdown" 
             aria-expanded="false"
           >
             <i className="fas fa-plus me-2"></i> New Message
           </button>
           <ul className="dropdown-menu w-100" aria-labelledby="newMessageDropdown">
             {contacts.map(contact => (
               <li key={contact.id}>
                 <a 
                   className="dropdown-item start-chat-btn d-flex align-items-center"
                   href="#" 
                   onClick={(e) => { 
                     e.preventDefault();
                     handleStartChat(contact);
                   }}
                 >
                   <div className="chat-avatar me-2" style={{ width: '25px', height: '25px' }}>
                     <div 
                       className={`avatar-placeholder ${getRoleBadgeClass(contact.role_id)} text-white`}
                       style={{ width: '20px', height: '20px', fontSize: '10px' }}
                     >
                       {getInitials(`${contact.first_name} ${contact.last_name}`)}
                     </div>
                   </div>
                   <span>{contact.first_name} {contact.last_name}</span>
                   <span className={`ms-auto badge ${getRoleBadgeClass(contact.role_id)}`}>
                     {getRoleName(contact.role_id)}
                   </span>
                 </a>
               </li>
             ))}
           </ul>
         </div>
       </div>
     )}

     {/* Search */}
     <div className="chat-search p-3 border-bottom">
       <div className="input-group">
         <span className="input-group-text bg-light border-0">
           <i className="fas fa-search text-muted"></i>
         </span>
         <input 
           type="text" 
           id="conversationSearch"
           className="form-control border-0 bg-light"
           placeholder="Search conversations..."
           value={searchQuery}
           onChange={handleSearch}
         />
       </div>
     </div>

     {/* Conversation List */}
     <div className="conversation-list">
       {filteredConversations && filteredConversations.length > 0 ? (
         filteredConversations.map(conversation => {
           const otherParticipant = conversation.participants?.[0];
           if (!otherParticipant) return null;
           
           const unreadCount = conversation.unread_count || 0;
           const lastMessage = conversation.latest_message;
           const isActive = conversation.id === parseInt(activeConversationId);
           
           return (
             <div 
               key={conversation.id}
               className={`conversation-item ${isActive ? 'active' : ''}`}
               data-conversation-id={conversation.id}
               onClick={() => handleConversationClick(conversation)}
             >
               <div className="chat-avatar">
                 <div className={`avatar-placeholder ${getRoleBadgeClass(otherParticipant.role_id)} text-white`}>
                   {getInitials(`${otherParticipant.first_name} ${otherParticipant.last_name}`)}
                 </div>
                 <span 
                   className={`status-indicator ${otherParticipant.online_status || 'offline'}`}
                   data-user-id={otherParticipant.id}
                 ></span>
               </div>
               <div className="conversation-info">
                 <h6 className="mb-1 conversation-name">
                   {otherParticipant.first_name} {otherParticipant.last_name}
                 </h6>
                 <p className="text-muted mb-0 last-message">
                   {lastMessage ? (
                     lastMessage.has_attachments && !lastMessage.message ? (
                       <><i className="fas fa-paperclip me-1"></i> Attachment</>
                     ) : (
                       lastMessage.message?.length > 30 ? 
                         `${lastMessage.message.substring(0, 30)}...` : 
                         lastMessage.message
                     )
                   ) : (
                     'Start a conversation'
                   )}
                 </p>
               </div>
               <div className="conversation-meta">
                 {lastMessage && (
                   <span className="message-time">
                     {lastMessage.formatted_time || 
                       new Date(lastMessage.created_at).toLocaleTimeString([], {
                         hour: 'numeric',
                         minute: '2-digit'
                       })
                     }
                   </span>
                 )}
                 {unreadCount > 0 && (
                   <span className="unread-badge">{unreadCount}</span>
                 )}
               </div>
             </div>
           );
         })
       ) : (
         <div className="text-center py-5">
           <div className="empty-state-icon mb-3">
             <i className="fas fa-comments text-muted"></i>
           </div>
           <h6 className="text-muted">No conversations yet</h6>
           <p className="small text-muted">
             {currentUser?.role_id === 3 ? 
               'Messages with your mentor will appear here' : 
               currentUser?.role_id === 2 ? 
                 'Messages with your interns will appear here' : 
                 'Messages with mentors and interns will appear here'
             }
           </p>
         </div>
       )}
     </div>
   </div>
 );
}