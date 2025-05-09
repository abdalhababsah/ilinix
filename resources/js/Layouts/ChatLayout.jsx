import React from 'react';
import { Head } from '@inertiajs/inertia-react';

export default function ChatLayout({ children, title }) {
  return (
    <div className="chat-layout">
      <Head title={title} />

              <div className="card-body p-0">
                {children}

      </div>
    </div>
  );
}