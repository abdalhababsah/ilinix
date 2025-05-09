import React from 'react';

export default function MessageLoader() {
  return (
    <div className="messages-loading text-center py-5">
      <div className="spinner-border text-primary" role="status">
        <span className="visually-hidden">Loading...</span>
      </div>
      <p className="mt-2">Loading messages...</p>
    </div>
  );
}