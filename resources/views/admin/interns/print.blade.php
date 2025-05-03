<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interns Report - Ilinix Intern Tracker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #199254;
            --secondary: #5ace5a;
            --tertiary: #a0cc36;
            --quaternary: #36cc91;
            --primary-rgb: 25, 146, 84;
            --primary-darker: #167f49;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }

        .report-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary);
            position: relative;
        }

        .company-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .company-logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary);
            display: flex;
            align-items: center;
        }

        .company-logo i {
            margin-right: 10px;
            color: var(--primary);
        }

        .report-title {
            text-align: center;
            margin: 25px 0 15px;
        }

        .report-title h2 {
            font-size: 22px;
            color: var(--primary);
            margin: 0;
            font-weight: 600;
        }

        .report-meta {
            text-align: right;
            font-size: 11px;
            color: #666;
        }

        .filter-info {
            font-size: 11px;
            color: #666;
            background-color: #f9f9f9;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #e0e0e0;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f5f9f7;
            font-weight: 600;
            color: var(--primary-darker);
            white-space: nowrap;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f0f7f4;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #999;
            text-align: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .page-number {
            position: absolute;
            bottom: -10px;
            right: 0;
            font-size: 10px;
            color: #999;
        }

        .page-number:before {
            content: "Page ";
        }

        @media print {
            body {
                padding: 0.5cm;
            }

            .report-header {
                margin-bottom: 20px;
            }

            .filter-info {
                border: 1px solid #eee;
            }

            @page {
                size: A4;
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="report-header">
        <div class="company-info">
            <div class="company-logo">
                <i class="bi bi-building"></i> Ilinix Company
            </div>
            <div class="report-meta">
                <div>Generated: {{ now()->format('F d, Y h:i A') }}</div>
                <div>User: {{ auth()->user()->name }}</div>
            </div>
        </div>
        <div class="report-title">
            <h2>Interns Management Report</h2>
        </div>
    </div>

    @if(request()->anyFilled(['first_name', 'last_name', 'email']))
    <div class="filter-info">
        <strong>Filters:</strong>
        @if(request('first_name'))
        First Name: {{ request('first_name') }}
        @endif
        @if(request('last_name'))
        @if(request('first_name')) | @endif
        Last Name: {{ request('last_name') }}
        @endif
        @if(request('email'))
        @if(request('first_name') || request('last_name')) | @endif
        Email: {{ request('email') }}
        @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            @forelse($interns as $intern)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $intern->first_name }}</td>
                    <td>{{ $intern->last_name }}</td>
                    <td>{{ $intern->email }}</td>
                    <td>{{ ucfirst($intern->status ?? 'Active') }}</td>
                    <td>{{ $intern->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">No interns found matching your criteria.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} Ilinix Company. All rights reserved. Intern Tracking System. This report is confidential and intended only for authorized personnel.
    </div>

    <script>
        window.onload = function () {
            // Add page numbers
            const totalPages = Math.ceil(document.body.scrollHeight / 1123); // A4 height in pixels at 96 DPI
            for (let i = 1; i <= totalPages; i++) {
                const pageNumber = document.createElement('div');
                pageNumber.className = 'page-number';
                pageNumber.textContent = i + ' of ' + totalPages;
                document.body.appendChild(pageNumber);
                pageNumber.style.top = ((i * 1123) - 20) + 'px';
            }
            
            // Trigger print
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>