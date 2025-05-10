@extends('dashboard-layout.app')

@section('content')
    <div class="container">
        <div class="page-title-container mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1 class="mb-0 pb-0 display-4 text-primary fw-bold" id="title">Onboarding Steps</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                    class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Onboarding Steps</li>
                        </ul>
                    </nav>
                </div>
                <div class="col-12 col-md-5 d-flex align-items-center justify-content-md-end mt-3 mt-md-0 gap-2">
                    <a href="{{ route('admin.onboarding.create') }}" class="btn btn-primary">
                        <i data-acorn-icon="plus" class="me-2"></i> Add New Step
                    </a>
                </div>
            </div>
        </div>

        @include('components._messages')
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Onboarding Steps</h5>
                        <div class="btn-group">
                            <button class="btn btn-primary" id="saveOrderBtn" style="display: none;">
                                <i data-acorn-icon="save" class="me-1"></i> Save New Order
                            </button>
                            <!-- Reset button will be dynamically added here -->
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($steps->count() > 0)
                            <div id="orderActionMessages"></div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th width="60">#</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th width="160">Resource</th>
                                            <th width="140">Completion</th>
                                            <th width="140">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortableSteps">
                                        @foreach ($steps as $step)
                                            <tr data-id="{{ $step->id }}" class="sortable-row">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="sort-handle me-2 cursor-pointer text-muted">
                                                            <i data-acorn-icon="arrow-up-down"></i>
                                                        </span>
                                                        <span class="badge bg-primary">{{ $step->step_order }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $step->title }}</td>
                                                <td>{!! \Illuminate\Support\Str::limit(strip_tags($step->description), 80) !!}</td>
                                                <td>
                                                    @if ($step->resource_link)
                                                        <a href="{{ asset('storage/' . $step->resource_link) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i data-acorn-icon="download" class="me-1"></i> Download
                                                        </a>
                                                    @else
                                                        <span class="text-muted">No resource</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $completedCount = $step->userOnboardingSteps
                                                            ->where('is_completed', true)
                                                            ->count();
                                                        $totalCount = $step->userOnboardingSteps->count();
                                                        $completionRate =
                                                            $totalCount > 0
                                                                ? round(($completedCount / $totalCount) * 100)
                                                                : 0;
                                                    @endphp
                                                    <div class="progress mb-2" style="height: 8px;">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{ $completionRate }}%;"
                                                            aria-valuenow="{{ $completionRate }}" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="text-muted small text-center">
                                                        {{ $completionRate }}%
                                                        ({{ $completedCount }}/{{ $internsCount }})
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.onboarding.edit', $step->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                                            <i data-acorn-icon="edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.onboarding.destroy', $step->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Delete"
                                                                onclick="return confirm('Are you sure you want to delete this step? This will remove it from all interns.')">
                                                                <i data-acorn-icon="bin"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i data-acorn-icon="list-check" style="font-size: 3rem;" class="text-muted mb-3"></i>
                                <h6 class="text-muted">No onboarding steps defined yet</h6>
                                <p>Start by adding your first onboarding step.</p>
                                <a href="{{ route('admin.onboarding.create') }}" class="btn btn-primary mt-2">
                                    <i data-acorn-icon="plus" class="me-2"></i> Add First Step
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .sort-handle {
                cursor: grab;
                padding: 5px;
                border-radius: 4px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
                width: 28px;
                height: 28px;
                background-color: rgba(var(--primary-rgb), 0.1);
            }

            .sort-handle:hover {
                background-color: rgba(var(--primary-rgb), 0.2);
            }

            .sort-handle:active {
                cursor: grabbing;
                background-color: rgba(var(--primary-rgb), 0.3);
            }

            .handle-icon {
                font-size: 16px;
                color: var(--primary);
            }

            .grip-dots {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                grid-gap: 2px;
                width: 12px;
                height: 12px;
                margin-top: 2px;
            }

            .grip-dot {
                width: 3px;
                height: 3px;
                background-color: var(--primary);
                border-radius: 50%;
            }

            .sortable-ghost .sort-handle {
                background-color: rgba(var(--primary-rgb), 0.3);
            }

            .sortable-chosen {
                background-color: rgba(var(--primary-rgb), 0.05);
                box-shadow: 0 0 10px rgba(var(--primary-rgb), 0.1);
            }

            .sortable-drag {
                opacity: 0.8;
                background-color: #fff;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            }

            /* Enhanced visual feedback for the entire row */
            tr.sortable-row {
                transition: all 0.2s ease;
            }

            tr.sortable-row:hover .sort-handle {
                background-color: rgba(var(--primary-rgb), 0.2);
            }

            /* Make sure the entire row looks draggable */
            body.is-dragging .sortable-row {
                cursor: grabbing;
            }

            .badge-order {
                min-width: 28px;
                display: inline-block;
                text-align: center;
            }

            #saveOrderBtn,
            #resetOrderBtn {
                transition: all 0.3s ease;
            }

            .reordering-banner {
                background-color: rgba(var(--primary-rgb), 0.1);
                border-left: 4px solid var(--primary);
                padding: 10px 15px;
                margin-bottom: 15px;
                border-radius: 4px;
                display: none;
            }

            .badge-order {
                min-width: 28px;
                display: inline-block;
                text-align: center;
            }

            @keyframes highlight-row {
                0% {
                    background-color: rgba(var(--primary-rgb), 0.2);
                }

                100% {
                    background-color: transparent;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize sortable for step reordering
                const sortableList = document.getElementById('sortableSteps');
                const saveOrderBtn = document.getElementById('saveOrderBtn');
                const messageContainer = document.getElementById('orderActionMessages');

                if (sortableList) {
                    // Create and add reset button
                    const resetOrderBtn = document.createElement('button');
                    resetOrderBtn.className = 'btn btn-outline-secondary';
                    resetOrderBtn.id = 'resetOrderBtn';
                    resetOrderBtn.innerHTML = '<i data-acorn-icon="rotate-left" class="me-1"></i> Reset Order';
                    resetOrderBtn.style.display = 'none';
                    saveOrderBtn.parentNode.appendChild(resetOrderBtn);

                    // Create reordering banner
                    const reorderBanner = document.createElement('div');
                    reorderBanner.className = 'reordering-banner';
                    reorderBanner.id = 'reorderBanner';
                    reorderBanner.innerHTML =
                        '<i data-acorn-icon="arrow-up-down" class="me-2"></i> Drag steps to reorder them. Click "Save New Order" when done.';
                    messageContainer.appendChild(reorderBanner);

                    let originalOrder = [];
                    let stepOrder = [];
                    let orderChanged = false;

                    // Store the original order for reset functionality
                    originalOrder = Array.from(sortableList.querySelectorAll('tr')).map(row => row.dataset.id);

                    const sortable = new Sortable(sortableList, {
                        handle: '.sort-handle',
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        dragClass: 'sortable-drag',
                        delay: 100, // Add a slight delay to prevent accidental drags
                        delayOnTouchOnly: true, // Only add delay on touch devices
                        onStart: function(evt) {
                            document.body.classList.add('is-dragging');

                            // Add visual feedback to the row being dragged
                            const item = evt.item;
                            item.style.background = 'rgba(var(--primary-rgb), 0.05)';

                            // Show instruction banner
                            document.getElementById('reorderBanner').style.display = 'block';
                        },
                        onEnd: function(evt) {
                            document.body.classList.remove('is-dragging');

                            // Remove background highlight
                            const item = evt.item;
                            item.style.background = '';

                            // Update order and check for changes
                            updateStepOrder();
                            checkOrderChanged();
                            updateOrderNumbers();

                            // If the user just clicked without dragging, don't show action buttons
                            if (evt.oldIndex === evt.newIndex) {
                                return;
                            }

                            // Highlight the row that was moved to show what changed
                            item.style.animation = 'highlight-row 1s ease';
                            setTimeout(() => {
                                item.style.animation = '';
                            }, 1000);
                        }
                    });

                    // Function to collect current order
                    function updateStepOrder() {
                        const rows = sortableList.querySelectorAll('tr');
                        stepOrder = Array.from(rows).map(row => row.dataset.id);
                    }

                    // Update the visual order numbers
                    function updateOrderNumbers() {
                        const rows = sortableList.querySelectorAll('tr');
                        rows.forEach((row, index) => {
                            const badge = row.querySelector('.badge');
                            if (badge) {
                                badge.textContent = index + 1;
                            }
                        });
                    }

                    // Check if order changed from original
                    function checkOrderChanged() {
                        if (JSON.stringify(originalOrder) !== JSON.stringify(stepOrder)) {
                            orderChanged = true;
                            saveOrderBtn.style.display = 'inline-block';
                            resetOrderBtn.style.display = 'inline-block';
                            reorderBanner.style.display = 'block';

                            // Add clear visual indication that order has changed
                            sortableList.classList.add('order-changed');
                        } else {
                            orderChanged = false;
                            saveOrderBtn.style.display = 'none';
                            resetOrderBtn.style.display = 'none';
                            reorderBanner.style.display = 'none';

                            // Remove visual indication
                            sortableList.classList.remove('order-changed');
                        }
                    }

                    // Save button handler
                    saveOrderBtn.addEventListener('click', function() {
                        if (!orderChanged) return;

                        // Show loading state
                        const originalBtnContent = saveOrderBtn.innerHTML;
                        saveOrderBtn.innerHTML =
                            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...';
                        saveOrderBtn.disabled = true;
                        resetOrderBtn.disabled = true;

                        fetch('{{ route('admin.onboarding.update-order') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    steps: stepOrder
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Show success message
                                    const alert = document.createElement('div');
                                    alert.className = 'alert alert-success alert-dismissible fade show';
                                    alert.innerHTML =
                                        '<i data-acorn-icon="check" class="me-2"></i>Order updated successfully!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

                                    messageContainer.innerHTML = '';
                                    messageContainer.appendChild(alert);

                                    // Update original order to match current
                                    originalOrder = [...stepOrder];

                                    // Reset UI state
                                    orderChanged = false;
                                    sortableList.classList.remove('order-changed');
                                    reorderBanner.style.display = 'none';

                                    // Reload page after short delay
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1500);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);

                                // Show error message
                                const alert = document.createElement('div');
                                alert.className = 'alert alert-danger alert-dismissible fade show';
                                alert.innerHTML =
                                    '<i data-acorn-icon="warning-hexagon" class="me-2"></i>An error occurred while saving the order. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

                                messageContainer.innerHTML = '';
                                messageContainer.appendChild(alert);
                            })
                            .finally(() => {
                                // Reset button state
                                saveOrderBtn.innerHTML = originalBtnContent;
                                saveOrderBtn.disabled = false;
                                resetOrderBtn.disabled = false;
                            });
                    });

                    // Reset button handler
                    resetOrderBtn.addEventListener('click', function() {
                        if (!orderChanged) return;

                        // Restore original order
                        const rows = Array.from(sortableList.querySelectorAll('tr'));
                        const tbody = sortableList;

                        // Sort rows based on original order
                        rows.sort((a, b) => {
                            const indexA = originalOrder.indexOf(a.dataset.id);
                            const indexB = originalOrder.indexOf(b.dataset.id);
                            return indexA - indexB;
                        });

                        // Clear and re-append rows
                        tbody.innerHTML = '';
                        rows.forEach(row => tbody.appendChild(row));

                        // Update visual order numbers
                        updateOrderNumbers();

                        // Update state
                        stepOrder = [...originalOrder];
                        orderChanged = false;
                        sortableList.classList.remove('order-changed');
                        saveOrderBtn.style.display = 'none';
                        resetOrderBtn.style.display = 'none';
                        reorderBanner.style.display = 'none';

                        // Show reset confirmation message
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-info alert-dismissible fade show';
                        alert.innerHTML =
                            '<i data-acorn-icon="rotate-left" class="me-2"></i>Order has been reset to original.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

                        messageContainer.innerHTML = '';
                        messageContainer.appendChild(alert);
                    });
                }
            });
        </script>
    @endpush
@endsection
