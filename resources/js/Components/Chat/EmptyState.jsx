import React from 'react';

export default function EmptyState({ currentUser, contacts, onStartChat }) {
  // Check if the user is an intern and has a mentor
  const isMentorAvailable = currentUser.role_id === 3 && contacts && contacts.length > 0 && contacts[0].role_id === 2;
  
  const handleStartChat = (contact) => {
    onStartChat(contact.id);
  };
  
  // Get role badge class based on role ID
  const getRoleBadgeClass = (roleId) => {
    if (roleId === 1) return 'bg-warning';
    if (roleId === 2) return 'bg-primary';
    return 'bg-secondary';
  };
  
  // Get role name based on role ID
  const getRoleName = (roleId) => {
    if (roleId === 1) return 'Admin';
    if (roleId === 2) return 'Mentor';
    return 'Intern';
  };
  
  // Get user initials for avatar
  const getInitials = (name) => {
    if (!name) return '??';
    return name.split(' ')
      .map(part => part[0])
      .join('')
      .toUpperCase()
      .substring(0, 2);
  };
  
  return (
    <div className="chat-empty text-center">
      <div className="empty-illustration mb-4">
        <i className="fas fa-comment-dots"></i>
      </div>
      <h4>Select a conversation</h4>
      <p className="text-muted">Choose a conversation from the list or start a new one</p>
      
      {contacts && contacts.length > 0 && (
        <div className="mt-4">
          {isMentorAvailable ? (
            <button 
              className="btn btn-primary"
              onClick={() => handleStartChat(contacts[0])}
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
          )}
        </div>
      )}
    </div>
  );
}