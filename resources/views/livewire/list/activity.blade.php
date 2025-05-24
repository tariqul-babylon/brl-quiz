<div>
    <div class="d-flex align-items-end mb-2 justify-content-between">
        <h3>Laravel Logger Activity | Total {{ $logs->total() }}</h3>
        <select wire:model='per_page'>
            <option>10</option>
            <option>15</option>
            <option>30</option>
            <option>50</option>
            <option>100</option>
            <option>250</option>
            <option>500</option>
            <option>1000</option>
            <option>2000</option>
            <option>3000</option>
        </select>
    </div>
    <div wire:loading class="wireload">
        <x-loading />
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row row-cols-6 g-2 mb-2">
                <div>
                    <label for="" class="optional">User Type</label>
                    <div wire:ignore>
                        <select id='user_type' class="form-select form-select-sm">
                            <option value="">Select</option>
                            <option>Guest</option>
                            <option>Registered</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="" class="optional">User</label>
                    <div wire:ignore>
                        <select id='user_id' class="form-select form-select-sm">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="" class="optional">Route</label>
                    <div wire:ignore>
                        <select id='method' class="form-select form-select-sm">
                            <option value="">Select Route</option>
                            <option>GET</option>
                            <option>POST</option>
                            <option>PUT</option>
                            <option>DELETE</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="" class="optional">Order By</label>
                    <div wire:ignore>
                        <select id='order_by' class="form-select form-select-sm">
                            <option value="">Select</option>
                            <option>Create At DESC</option>
                            <option>Create At ASC</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="" class="optional">Date From</label>
                    <input type="text" class="form-control form-control-sm" id="date_from" wire:model='date_from'>
                </div>

                <div class="@if (!$date_from) d-none @endif">
                    <label for="" class="optional">Time From</label>

                    <input type="text" class="form-control form-control-sm" wire:model='time_from' id="time_from">
                </div>

                <div>
                    <label for="" class="optional">Date To</label>
                    <input type="text" class="form-control form-control-sm" id="date_to" wire:model.lazy='date_to'>
                </div>


                <div class="@if (!$date_to) d-none @endif">
                    <label for="" class="optional">Time To {{ $time_to }}</label>
                    <input type="text" class="form-control form-control-sm" wire:model.lazy='time_to' id="time_to">
                </div>

                <div>
                    <label for="" class="optional">IP Address</label>
                    <input type="text" class="form-control form-control-sm" wire:model.lazy='ip'>
                </div>
                <div>
                    <label for="" class="optional">Has Not IP Address</label>
                    <input type="text" class="form-control form-control-sm" wire:model.lazy='has_not_ip'>
                </div>

                <div>
                    <label for="" class="optional">Description</label>
                    <input type="text" class="form-control form-control-sm" wire:model.lazy='description'>
                </div>
                <div>
                    <label for="" class="optional">Route</label>
                    <input type="text" class="form-control form-control-sm" wire:model.lazy='route'>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Sl. No.</th>
                            <th>User</th>
                            <th>Description</th>
                            <th>Agent</th>
                            <th width="100">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $logs->firstItem() + $loop->index }}</td>
                                <td>
                                    {{ $log->user?->name }}
                                    @if ($log->userType == 'Guest')
                                        <span class="badge bg-warning">Guest</span>
                                    @endif
                                    <small class="d-block">
                                        {{ $log->ipAddress }}
                                    </small>
                                </td>
                                <td>
                                    {{ $log->description }}
                                    <hr class="my-0">
                                    @if ($log->methodType == 'GET')
                                        <span class="badge bg-secondary">{{ strtolower($log->methodType) }}</span>
                                    @elseif($log->methodType == 'POST')
                                        <span class="badge bg-success">{{ strtolower($log->methodType) }}</span>
                                    @elseif($log->methodType == 'PUT')
                                        <span class="badge bg-warning">{{ strtolower($log->methodType) }}</span>
                                    @elseif($log->methodType == 'DELETE')
                                        <span class="badge bg-danger">{{ strtolower($log->methodType) }}</span>
                                    @else
                                        {{ $log->methodType }}
                                    @endif
                                    {{ $log->route }}
                                </td>

                                <td>
                                    @php
                                        $agent = new Jenssegers\Agent\Agent();
                                        $agent->setUserAgent($log->userAgent);
                                        $platform = $agent->platform();
                                        $platformVersion = $agent->version($platform);
                                        $browser = $agent->browser();
                                        $browserVersion = $agent->version($browser);
                                        $isMobile = $agent->isMobile();
                                        // $isDesktop = $agent->isDesktop();
                                    @endphp
                                    <small>
                                        <div class="d-flex align-items-center">
                                            @if ($isMobile)
                                                <span style="font-size: 12px;" class="material-symbols-outlined me-1">
                                                    smartphone
                                                </span>
                                            @else
                                                <span style="font-size: 12px;" class="material-symbols-outlined me-1">
                                                    computer
                                                </span>
                                            @endif
                                            <span>
                                                {{ $platform }} {{ $platformVersion }}
                                            </span>
                                        </div>
                                        <div>
                                            {{ $browser }} {{ $browserVersion }}
                                        </div>

                                    </small>
                                </td>

                                <td>
                                    {{ $log->created_at->format('d M Y') }}
                                    <div>
                                        {{ $log->created_at->format('h:i:s A') }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    @push('js')
        <script>
            function setChangedData(componentName) {
                $(`#${componentName}`).select2({
                    'theme': 'bootstrap-5'
                });
                $(`#${componentName}`).on('change', function(e) {
                    let data = $(`#${componentName}`).select2("val");
                    // In Livewire 3, you can use either:
                    // Option 1: Directly set the property (recommended)
                    @this.set(componentName, data);

                    // Option 2: Emit an event (if you need cross-component communication)
                    // Livewire.dispatch('dataChanged', { componentName, data });
                });
            }

            document.addEventListener('livewire:init', function() {
                // Initialize date pickers
                const create_date_from = $('#date_from').flatpickr({
                    dateFormat: "d/m/Y",
                    defaultDate: "{{ $date_from }}",
                    maxDate: "{{ $today->format('d/m/Y') }}"
                });

                const create_date_to = $('#date_to').flatpickr({
                    dateFormat: "d/m/Y",
                    defaultDate: "{{ $date_to }}",
                    maxDate: "{{ $today->format('d/m/Y') }}"
                });

                $('#time_from').flatpickr({
                    dateFormat: "H:i",
                    enableTime: true,
                    noCalendar: true
                });

                $('#time_to').flatpickr({
                    dateFormat: "H:i",
                    enableTime: true,
                    noCalendar: true
                });

                // Initialize Select2 elements
                setChangedData('user_type');
                setChangedData('user_id');
                setChangedData('method');
                setChangedData('order_by');

                // Livewire 3 way to listen for events (if needed)
                Livewire.on('dataChanged', ({
                    componentName,
                    data
                }) => {
                    console.log('Data changed:', componentName, data);
                });
            });
        </script>
    @endpush
</div>
