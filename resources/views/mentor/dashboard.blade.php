@extends('dashboard-layout.app')

@section('title', 'Mentor Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Dashboard Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-0 display-4">Mentor Dashboard</h1>
                <p class="text-muted">Welcome back, {{ $mentor->first_name }}! Here's an overview of your assigned interns.
                </p>
            </div>
        </div>
        <!-- Certificate Statistics -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Certificate Completion Statistics</h6>
                    </div>
                    <div class="card-body">
                        @if (count($certificateStats) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Certificate</th>
                                            <th>Provider</th>
                                            <th>Started</th>
                                            <th>Completed</th>
                                            <th>In Progress</th>
                                            <th>Completion Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($certificateStats as $stat)
                                            <tr>
                                                <td>{{ $stat['certificate']->title }}</td>
                                                <td>{{ $stat['certificate']->provider->name }}</td>
                                                <td>{{ $stat['total_started'] }}</td>
                                                <td>{{ $stat['completed'] }}</td>
                                                <td>{{ $stat['in_progress'] }}</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $stat['completion_rate'] }}%;"
                                                            aria-valuenow="{{ $stat['completion_rate'] }}" aria-valuemin="0"
                                                            aria-valuemax="100">{{ $stat['completion_rate'] }}%</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-certificate fa-3x text-info mb-3"></i>
                                <p>No certificate data available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Interns Table -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">All Assigned Interns</h6>
                    </div>
                    <div class="card-body">
                        @if (count($interns) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="internTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Active Certificates</th>
                                            <th>Overall Progress</th>
                                            <th>Last Activity</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($interns as $intern)
                                            @php
                                                $totalCourses = 0;
                                                $completedCourses = 0;

                                                foreach ($intern->certificates as $cert) {
                                                    $coursesInCert = $cert->certificate->courses->count();
                                                    $totalCourses += $coursesInCert;

                                                    $completedInCert = $intern->progressUpdates
                                                        ->where('certificate_id', $cert->certificate_id)
                                                        ->where('is_completed', true)
                                                        ->count();

                                                    $completedCourses += $completedInCert;
                                                }

                                                $overallProgress =
                                                    $totalCourses > 0
                                                        ? round(($completedCourses / $totalCourses) * 100)
                                                        : 0;

                                                // Get latest activity
                                                $lastActivity = $intern->last_login_at;
                                                $latestProgress = $intern->progressUpdates
                                                    ->sortByDesc('created_at')
                                                    ->first();
                                                if ($latestProgress && $latestProgress->created_at > $lastActivity) {
                                                    $lastActivity = $latestProgress->created_at;
                                                }
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a href="{{ route('mentor.interns.show', $intern->id) }}">
                                                        {{ $intern->first_name }} {{ $intern->last_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $intern->email }}</td>
                                                <td>
                                                    @php
                                                        $totalCertificates = $intern->certificates->count();
                                                        $completedCertificates = $intern->certificates
                                                            ->where('completed_at', '!=', null)
                                                            ->count();
                                                    @endphp
                                                    {{ $completedCertificates }} / {{ $totalCertificates }}
                                                    @if ($totalCertificates > 0)
                                                        <div class="progress progress-sm mt-1">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: {{ ($completedCertificates / $totalCertificates) * 100 }}%"
                                                                aria-valuenow="{{ ($completedCertificates / $totalCertificates) * 100 }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <small class="text-muted">No certificates started</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $overallProgress }}%;"
                                                            aria-valuenow="{{ $overallProgress }}" aria-valuemin="0"
                                                            aria-valuemax="100">{{ $overallProgress }}%</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($lastActivity)
                                                        {{ $lastActivity->diffForHumans() }}
                                                    @else
                                                        Never
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('mentor.interns.show', $intern->id) }}"
                                                        class="btn btn-sm btn-sm-admin btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-info mb-3"></i>
                                <p>No interns assigned to you yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Inactive Interns and Recent Progress -->
        <div class="row">
            <!-- Inactive Interns -->
            <div class="col-xl-5 col-lg-5 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Inactive Interns (14+ days)</h6>
                    </div>
                    <div class="card-body">
                        @if (count($inactiveInterns) > 0)
                            <div class="list-group">
                                @foreach ($inactiveInterns as $inactive)
                                    <a href="{{ route('mentor.interns.show', $inactive['intern']->id) }}"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $inactive['intern']->first_name }}
                                                {{ $inactive['intern']->last_name }}</h5>
                                            <small>
                                                @if ($inactive['last_activity'])
                                                    Last active: {{ $inactive['last_activity']->diffForHumans() }}
                                                @else
                                                    Never active
                                                @endif
                                            </small>
                                        </div>
                                        <p class="mb-1">{{ $inactive['intern']->email }}</p>
                                        <small>
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation-circle"></i>
                                                No recent activity
                                            </span>
                                        </small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-success mb-3"></i>
                                <p>All interns are actively engaged!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Progress Updates -->
            <div class="col-xl-7 col-lg-7 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Progress Updates</h6>
                    </div>
                    <div class="card-body">
                        @if (count($recentProgressUpdates) > 0)
                            <div class="timeline">
                                @foreach ($recentProgressUpdates as $update)
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">
                                                {{ $update->created_at->format('M d') }}
                                            </div>
                                            <div
                                                class="timeline-item-marker-indicator bg-{{ $update->is_completed ? 'success' : 'primary' }}">
                                            </div>
                                        </div>
                                        <div class="timeline-item-content">
                                            <a href="{{ route('mentor.interns.show', $update->intern_id) }}"
                                                class="font-weight-bold">
                                                {{ $update->intern->first_name }} {{ $update->intern->last_name }}
                                            </a>
                                            {{ $update->is_completed ? 'completed' : 'updated progress for' }}
                                            <strong>{{ $update->course->title }}</strong>
                                            in {{ $update->certificate->title }}
                                            <div class="timeline-item-time">{{ $update->created_at->diffForHumans() }}
                                            </div>
                                            @if ($update->comment)
                                                <div class="mt-2">
                                                    <small class="text-muted">{{ $update->comment }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-chart-line fa-3x text-info mb-3"></i>
                                <p>No recent progress updates.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Certificate Statistics -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Certificate Completion Statistics</h6>
                    </div>
                    <div class="card-body">
                        @if (count($certificateStats) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Certificate</th>
                                            <th>Provider</th>

                                            <th>Completed</th>
                                            <th>In Progress</th>

                                            <th>Completion Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($certificateStats as $stat)
                                            <tr>
                                                <td>{{ $stat['certificate']->title }}</td>
                                                <td>{{ $stat['certificate']->provider->name }}</td>

                                                <td>{{ $stat['completed'] }}</td>
                                                <td>{{ $stat['in_progress'] }}</td>

                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $stat['completion_rate'] }}%;"
                                                            aria-valuenow="{{ $stat['completion_rate'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            {{ $stat['completion_rate'] }}%</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-certificate fa-3x text-info mb-3"></i>
                                <p>No certificate data available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- Content Row -->
        <div class="row">
            <!-- Pending Voucher Requests -->
            <div class="col-xl-12 col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Pending Voucher Requests</h6>
                    </div>
                    <div class="card-body">
                        @if (count($pendingVoucherRequests) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Intern</th>
                                            <th>Certificate</th>
                                            <th>Requested</th>
                                            {{-- <th>Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendingVoucherRequests as $request)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('mentor.interns.show', $request['intern']->id) }}">
                                                        {{ $request['intern']->first_name }}
                                                        {{ $request['intern']->last_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $request['certificate']->title }}</td>
                                                <td>{{ $request['requested_at']->diffForHumans() }}</td>
                                                {{-- <td>
                                                    <button type="button" class="btn btn-sm btn-primary assign-voucher-btn"
                                                        data-toggle="modal" data-target="#assignVoucherModal"
                                                        data-intern-name="{{ $request['intern']->first_name }} {{ $request['intern']->last_name }}"
                                                        data-certificate-name="{{ $request['certificate']->title }}"
                                                        data-provider-id="{{ $request['certificate']->provider_id }}"
                                                        data-intern-certificate-id="{{ $request['intern_certificate_id'] }}">
                                                        Assign Voucher
                                                    </button>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <p>No pending voucher requests at this time.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>


        </div>
        <!-- Modals -->
        <!-- Assign Voucher Modal -->
        <div class="modal fade" id="assignVoucherModal" tabindex="-1" role="dialog"
            aria-labelledby="assignVoucherModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignVoucherModalLabel">Assign Voucher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('mentor.vouchers.assign') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="intern_certificate_id" id="internCertificateId">

                            <div class="mb-3">
                                <label for="internName" class="form-label">Intern</label>
                                <input type="text" class="form-control" id="internName" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="certificateName" class="form-label">Certificate</label>
                                <input type="text" class="form-control" id="certificateName" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="voucherCode" class="form-label">Select Voucher</label>
                                <select class="form-control" name="voucher_code" id="voucherCode" required>
                                    <option value="">Loading vouchers...</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Assign Voucher</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#internTable').DataTable();

            // Handle Assign Voucher button click
            $('.assign-voucher-btn').click(function() {
                var internName = $(this).data('intern-name');
                var certificateName = $(this).data('certificate-name');
                var providerId = $(this).data('provider-id');
                var internCertificateId = $(this).data('intern-certificate-id');

                $('#internName').val(internName);
                $('#certificateName').val(certificateName);
                $('#internCertificateId').val(internCertificateId);

                // Load available vouchers for this provider
                $.ajax({
                    url: '/mentor/vouchers/available/' + providerId,
                    type: 'GET',
                    success: function(response) {
                        var options = '<option value="">Select a voucher</option>';

                        if (response.length > 0) {
                            $.each(response, function(index, voucher) {
                                options += '<option value="' + voucher.code + '">' +
                                    voucher.code + '</option>';
                            });
                        } else {
                            options = '<option value="">No vouchers available</option>';
                        }

                        $('#voucherCode').html(options);
                    }
                });
            });
        });
    </script>
@endsection
