import React from 'react';

export default function MessageItem({ message, isOutgoing, currentUser }) {
  const getInitials = (name) => {
    if (!name) return '??';
    return name.split(' ')
      .map(part => part[0])
      .join('')
      .toUpperCase()
      .substring(0, 2);
  };
  
  // Get role-based colors
  const getRoleColor = (roleId) => {
    if (roleId === 1) return 'bg-warning';
    if (roleId === 2) return 'bg-primary';
    return 'bg-secondary';
  };
  
  // Get file icon based on mime type
  const getFileIcon = (mimeType) => {
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
  
  // Render message attachments
  const renderAttachments = () => {
    if (!message.attachments || message.attachments.length === 0) return null;
    
    return (
      <div className="message-attachments">
        {message.attachments.map((attachment) => 
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
        )}
      </div>
    );
  };
  
  // Render message status (for outgoing messages)
  const renderMessageStatus = () => {
    if (!isOutgoing) return null;
    
    if (message.failed) {
      return (
        <div className="message-status">
          <span className="status-text text-danger">
            <i className="fas fa-exclamation-circle"></i> Failed
          </span>
        </div>
      );
    }
    
    return (
      <div className="message-status">
        <span className="status-text">
          <i className={`fas fa-check${message.is_read ? '-double' : ''}`}></i> 
          {message.is_read ? 'Read' : 'Delivered'}
        </span>
      </div>
    );
  };
  
  return (
    <div className={`message-item ${isOutgoing ? 'outgoing' : ''}`} data-message-id={message.id}>
      <div className="message-avatar">
        <div className={`avatar-placeholder ${getRoleColor(message.sender.role_id)} text-white`}>
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
        
        {renderAttachments()}
        {renderMessageStatus()}
      </div>
    </div>
  );
}