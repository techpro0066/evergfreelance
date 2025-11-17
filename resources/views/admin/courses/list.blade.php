@extends('dashboard')

@section('title', 'Courses - EverGreen Freelancing')

@section('css')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" /> --}}
    <link rel="stylesheet" href="{{ asset('portal/css/dataTable.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <style>
        .courses-section {
            padding: 2rem 0;
        }
        
        .page-header {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .page-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #666;
            font-size: 0.95rem;
        }
        
        .btn-add-course {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-add-course:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(51, 156, 181, 0.3);
            color: white;
        }
        
        .courses-table-card {
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
        
        .course-image {
            height: 6rem;
            border-radius: 6px;
            object-fit: cover;
        }
        
        .course-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
            font-size: 1rem;
        }
        
        .course-category {
            font-size: 0.85rem;
            color: #6c757d;
            background: #e9ecef;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }
        
        .course-price {
            font-weight: 600;
            color: #28a745;
        }
        
        .course-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-draft {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
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
        
        .btn-edit {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-edit:hover {
            background: #e0a800;
            transform: translateY(-1px);
            color: #212529;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-1px);
            color: white;
        }
        
        .btn-module {
            background: #339CB5;
            color: white;
        }
        
        .btn-module:hover {
            background: #2a7a8f;
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
        
        .back-btn {
            background: none;
            border: none;
            color: #339CB5;
            font-size: 1.1rem;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            margin-right: 1rem;
        }
        
        .back-btn:hover {
            background: rgba(51, 156, 181, 0.1);
            color: #2a7a8f;
        }
        
        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }
            
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
    </style>
@endsection

@section('content')
<div class="main-content">
    <!-- Topbar -->
    @include('dashboard.components.header')
    <main class="page-content">
        <div class="courses-section">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="page-title">Courses Management</h2>
                            <p class="page-subtitle">Manage all your courses, edit content, and track performance</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="{{ route('admin.courses.create') }}" class="btn-add-course">
                                <i class="fas fa-plus"></i>
                                {{ $list->count() == 0 ? 'Add First Course' : 'Add New Course' }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Courses Table -->
                @if($list->count() > 0)
                    <div class="courses-table-card">
                        <div class="table-header">
                            <h3 class="table-title">All Courses</h3>
                        </div>
                        
                        <div class="table-responsive">
                            <table id="coursesTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $item)
                                        <tr>
                                            <td width="40%">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{asset($item->thumbnail)}}" alt="Course" class="course-image me-3">
                                                    <div>
                                                        <div class="course-title">{{$item->title}}</div>
                                                        <small class="text-muted">{{Str::limit($item->header, 150)}}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="course-price text-center" width="20%">{{$item->price}}</td>
                                            <td width="20%" class="text-center"><span class="course-status {{$item->status == 'active' ? 'status-active' : 'status-inactive'}}">{{$item->status}}</span></td>
                                            <td width="20%" class="text-center">
                                                <div class="action-buttons dropdown">
                                                    <a href="{{ route('admin.courses.create', $item->id) }}" class="btn-action btn-edit" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn-action btn-delete" title="Delete" data-id="{{$item->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <a href="{{ route('admin.courses.module', $item->id) }}" class="btn-action btn-module" title="Module">
                                                        <i class="fas fa-list"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="courses-table-card">
                        <div class="table-header">
                            <h3 class="table-title">No courses found</h3>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts') 
    <script src="{{ asset('portal/js/dataTable.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
         $(document).ready(function() {
            // Initialize DataTable with sorting disabled
            $('#coursesTable').DataTable({
                "ordering": false
            });

            $('#coursesTable_wrapper').find('div.dt-layout-row:first').addClass('m-4');
        });

        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            var tr = $(this).closest('tr');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this course?',
                html: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.courses.delete')}}",
                        type: "POST",
                        data: {
                            _token: "{{csrf_token()}}",
                            id: id
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Course deleted successfully',
                                icon: 'success'
                            });
                            tr.remove();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection