import React from 'react';

export default function MessageDateDivider({ date }) {
  return (
    <div className="message-date-divider">
      <span className="message-date">{date}</span>
    </div>
  );
}