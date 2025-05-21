@extends('front.layouts.app')

@section('content')
   
 <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="m-0">Exam Result</h4>
                <p class="m-0 small">Soft skills exam for Mastul Foundation</p>
            </div>
            <div class="d-flex">
                <div class="input-group search-box">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by name or email...">
                    <button class="btn btn-outline-light" type="button" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="ms-3 winner-select">
                    <select class="form-select" id="winnersFilter">
                        <option value="" selected disabled>Select Winners</option>
                        <option value="all">All Participants</option>
                        <option value="top3">Top 3 Winners</option>
                        <option value="passed">Passed (7+ Correct)</option>
                    </select>
                    <button id="saveWinnersBtn" class="btn btn-success save-winners-btn">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="resultsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Correct</th>
                            <th>Wrong</th>
                            <th>Unanswered</th>
                            <th>Completion Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="1" class="top-score" data-status="top3">
                            <td>1</td>
                            <td>Arzeful Alam</td>
                            <td>arzeful.iahkder81@gmail.com</td>
                            <td class="fw-bold">11</td>
                            <td>4</td>
                            <td>0</td>
                            <td>01:56:57 PM</td>
                            <td>06:22</td>
                            <td><span class="badge badge-warning">Top Winner</span></td>
                        </tr>
                        <tr data-id="2" class="passed" data-status="passed">
                            <td>2</td>
                            <td>Aysha Siddiqua</td>
                            <td>aysha.siddiqua011@gmail.com</td>
                            <td class="fw-bold">9</td>
                            <td>6</td>
                            <td>0</td>
                            <td>01:57:00 PM</td>
                            <td>10:16</td>
                            <td><span class="badge badge-success">Passed</span></td>
                        </tr>
                        <tr data-id="3" class="passed" data-status="passed">
                            <td>3</td>
                            <td>Nafiya Sultana</td>
                            <td>maliyasultana@gmail.com</td>
                            <td class="fw-bold">9</td>
                            <td>6</td>
                            <td>0</td>
                            <td>01:56:57 PM</td>
                            <td>09:20</td>
                            <td><span class="badge badge-success">Passed</span></td>
                        </tr>
                        <tr data-id="4" class="passed" data-status="passed">
                            <td>4</td>
                            <td>Sonia</td>
                            <td>soniaakter812@gmail.com</td>
                            <td class="fw-bold">9</td>
                            <td>6</td>
                            <td>0</td>
                            <td>01:56:55 PM</td>
                            <td>06:26</td>
                            <td><span class="badge badge-success">Passed</span></td>
                        </tr>
                        <tr data-id="5" class="passed" data-status="passed">
                            <td>5</td>
                            <td>Syeda Prianka</td>
                            <td>priankamasud@gmail.com</td>
                            <td class="fw-bold">9</td>
                            <td>6</td>
                            <td>0</td>
                            <td>01:57:02 PM</td>
                            <td>06:12</td>
                            <td><span class="badge badge-success">Passed</span></td>
                        </tr>
                        <tr data-id="6" class="passed" data-status="passed">
                            <td>6</td>
                            <td>Marina Jahan</td>
                            <td>marinamoly@gmail.com</td>
                            <td>8</td>
                            <td>7</td>
                            <td>0</td>
                            <td>01:56:55 PM</td>
                            <td>08:26</td>
                            <td><span class="badge badge-success">Passed</span></td>
                        </tr>
                        <tr data-id="7" class="passed" data-status="passed">
                            <td>7</td>
                            <td>Md. Musifqur Rahman Alif</td>
                            <td>musifqurrahmanalif@gmail.com</td>
                            <td>8</td>
                            <td>7</td>
                            <td>0</td>
                            <td>01:56:54 PM</td>
                            <td>07:45</td>
                            <td><span class="badge badge-success">Passed</span></td>
                        </tr>
                        <tr data-id="8" data-status="participant">
                            <td>8</td>
                            <td>MD. ALIF AL MAHAMUD</td>
                            <td>APON1992@GMAIL.COM</td>
                            <td>7</td>
                            <td>8</td>
                            <td>0</td>
                            <td>01:56:51 PM</td>
                            <td>10:59</td>
                            <td><span class="badge badge-secondary">Participated</span></td>
                        </tr>
                        <tr data-id="9" data-status="participant">
                            <td>9</td>
                            <td>Kazi Raihan Rahman</td>
                            <td>firaihankaz101@gmail.com</td>
                            <td>7</td>
                            <td>8</td>
                            <td>0</td>
                            <td>01:56:55 PM</td>
                            <td>06:32</td>
                            <td><span class="badge badge-secondary">Participated</span></td>
                        </tr>
                        <tr data-id="10" data-status="participant">
                            <td>10</td>
                            <td>Pinky Datta</td>
                            <td>dattapinky20272027@gmail.com</td>
                            <td>6</td>
                            <td>8</td>
                            <td>1</td>
                            <td>01:57:05 PM</td>
                            <td>10:22</td>
                            <td><span class="badge badge-secondary">Participated</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="pagination-info">
                    Showing 1 to 10 of 12 entries
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter functionality
        document.getElementById('winnersFilter').addEventListener('change', function() {
            const filterValue = this.value;
            const saveBtn = document.getElementById('saveWinnersBtn');
            
            // Show/hide save button
            saveBtn.style.display = filterValue === 'all' ? 'none' : 'block';
            
            // Filter rows
            const rows = document.querySelectorAll('#resultsTable tbody tr');
            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                
                switch(filterValue) {
                    case 'all':
                        row.style.display = '';
                        break;
                    case 'top3':
                        row.style.display = status === 'top3' ? '' : 'none';
                        break;
                    case 'passed':
                        row.style.display = status === 'passed' ? '' : 'none';
                        break;
                }
            });
        });

        // Save winners functionality
        document.getElementById('saveWinnersBtn').addEventListener('click', function() {
            const selectedFilter = document.getElementById('winnersFilter').value;
            let winnerIds = [];
            
            // Collect IDs of visible winners
            document.querySelectorAll('#resultsTable tbody tr').forEach(row => {
                if (row.style.display !== 'none') {
                    const id = row.getAttribute('data-id');
                    if (id) winnerIds.push(id);
                }
            });
            
            // In a real application, you would send this to your server
            console.log('Saving winners with filter:', selectedFilter);
            console.log('Winner IDs:', winnerIds);
            
            // Show success message
            alert(`Successfully saved ${winnerIds.length} winners!`);
            
            // In a real app, you would use fetch() to send to your backend
            // fetch('/save-winners', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //     },
            //     body: JSON.stringify({
            //         filter_type: selectedFilter,
            //         winner_ids: winnerIds
            //     })
            // })
            // .then(response => response.json())
            // .then(data => {
            //     alert('Winners saved successfully!');
            // });
        });

        // Search functionality
        document.getElementById('searchBtn').addEventListener('click', function() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#resultsTable tbody tr');
            
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                
                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Allow Enter key to trigger search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('searchBtn').click();
            }
        });
    </script>
@endsection

@push ('js')
    <script>
      
    
    </script>
@endpush
