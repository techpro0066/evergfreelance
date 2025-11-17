@extends('dashboard')

@section('title', 'Users - EverGreen Freelancing')

@section('css')
    <link rel="stylesheet" href="{{ asset('portal/css/dataTable.css') }}">
    <style>
        .user-section {
            padding: 2rem 0;
        }
        
        .users-table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .table-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .table-title {
            color: #333;
            font-weight: 600;
            margin: 0;
        }
        
        .dataTables_wrapper {
            padding: 0;
        }
        
        .dataTables_filter {
            margin-bottom: 1rem;
        }
        
        .dataTables_filter input {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .dataTables_filter input:focus {
            border-color: #339CB5;
            box-shadow: 0 0 0 0.2rem rgba(51, 156, 181, 0.25);
            outline: none;
        }
        
        .table {
            margin: 0;
        }
        
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
            padding: 1rem;
            vertical-align: middle;
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .btn-action {
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .btn-course {
            background: #339CB5;
            color: white;
        }
        
        .btn-course:hover {
            background: #2a7a8f;
            transform: translateY(-1px);
            color: white;
        }

        .not-course {
            background: red;
            color: white;
        }

        .not-course:hover {
            background: #962c37;
            transform: translateY(-1px);
            color: white;
        }
        
       
        
        .dataTables_info {
            padding: 1rem 2rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .dataTables_paginate {
            padding: 1rem 2rem;
        }
        
        .paginate_button {
            border-radius: 6px !important;
            border: 1px solid #dee2e6 !important;
            margin: 0 0.125rem !important;
            padding: 0.5rem 0.75rem !important;
            color: #339CB5 !important;
            background: white !important;
        }
        
        .paginate_button:hover {
            background: #e9ecef !important;
            border-color: #339CB5 !important;
        }
        
        .paginate_button.current {
            background: #339CB5 !important;
            border-color: #339CB5 !important;
            color: white !important;
        }
        
        @media (max-width: 768px) {
            
            .table-header {
                padding: 1rem 1.5rem;
            }
            
            .dataTables_info,
            .dataTables_paginate {
                padding: 1rem 1.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .btn-action {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }
        
        /* Modal Custom Styling */
        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }
        
        .modal-title {
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }
        
        .btn-close:hover {
            opacity: 1;
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .modal-footer {
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }
        
        .modal-footer .btn {
            width: 100%;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .modal-footer .btn-primary {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            border: none;
        }
        
        .modal-footer .btn-primary:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(51, 156, 181, 0.3);
        }
        
        .modal-footer .btn-secondary {
            background: #6c757d;
            border: none;
        }
        
        .modal-footer .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }
        
        /* Mobile Responsive Modal Styles */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 1rem;
                max-width: calc(100% - 2rem);
            }
            
            .modal-header {
                padding: 1rem;
            }
            
            .modal-title {
                font-size: 1.1rem;
            }
            
            .modal-body {
                padding: 1.5rem 1rem;
            }
            
            .modal-footer {
                padding: 1rem;
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .modal-footer .btn {
                width: 100%;
                justify-content: center;
            }
        }
        
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
            
            .modal-header {
                padding: 0.75rem;
            }
            
            .modal-title {
                font-size: 1rem;
            }
            
            .modal-body {
                padding: 1rem 0.75rem;
            }
            
            .modal-footer {
                padding: 0.75rem;
            }
        }
        
        /* Animation for modal */
        .modal.fade .modal-dialog {
            transform: translate(0, -50px);
            transition: transform 0.3s ease-out;
        }
        
        .modal.show .modal-dialog {
            transform: translate(0, 0);
        }
        
        /* Loading state for save button */
        .btn-primary.loading {
            position: relative;
            color: transparent;
        }
        
        .btn-primary.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
    </style>
@endsection

@section('content')
<div class="main-content">
    <!-- Topbar -->
    @include('dashboard.components.header')
    <main class="page-content">
        @if($users->count() > 0)
            <div class="users-table-card">
                <div class="table-header">
                    <h3 class="table-title">All Users</h3>
                </div>
                
                <div class="table-responsive">
                    <table id="usersTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="40%">Name</th>
                                <th class="text-center" width="30%">Email</th>
                                <th class="text-center" width="20%">Courses</th>
                            </tr>
                        </thead>
                        <tbody class="tbody-user">
                            @foreach($users as $item)
                                <tr class="text-center">
                                    <td>{{$item->first_name}} {{$item->last_name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <button class="btn-action {{$item->buyCourses->count() > 0 ? 'btn-course' : 'not-course'}} px-5" title="Courses" data-id="{{$item->id}}">
                                                <i class="fas fa-book"></i> <span class="fw-bold ms-2">{{$item->buyCourses->count()}}</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="users-table-card">
                <div class="table-header text-center">
                    <h3 class="table-title">No users found</h3>
                </div>
            </div>
        @endif
    </main>
</div>

{{-- Add user --}}
<div class="modal fade" id="courses" tabindex="-1" aria-labelledby="coursesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coursesLabel">
                    <i class="fas fa-book me-2"></i>
                    <span>Courses</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('portal/js/dataTable.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "ordering": false
            });

            $('#usersTable_wrapper').find('div.dt-layout-row:first').addClass('m-4');
        });

        $(document).on('click', '.btn-course', function() {
            var id = $(this).data('id');
            var url = "{{ route('admin.users.courses', ':id') }}";

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    $('.modal-body').empty();
                    $('.modal-body').html(response);
                    $('#courses').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection