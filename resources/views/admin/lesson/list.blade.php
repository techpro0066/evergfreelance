@extends('dashboard')

@section('title', 'Lessons - EverGreen Freelancing')

@section('css')
    <link rel="stylesheet" href="{{ asset('portal/css/dataTable.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <style>
        .lessons-section {
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
        
        .btn-add-lesson {
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
        
        .btn-add-lesson:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(51, 156, 181, 0.3);
            color: white;
        }
        
        .lessons-table-card {
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

        .lesson-status {
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
        
        .btn-lesson-edit {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-lesson-edit:hover {
            background: #e0a800;
            transform: translateY(-1px);
            color: #212529;
        }
        
        .btn-file {
            background: #339CB5;
            color: white;
        }
        
        .btn-file:hover {
            background: #2a7a8f;
            transform: translateY(-1px);
            color: white;
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
        
        .btn-add-lesson {
            background: #339CB5;
            color: white;
        }
        
        .btn-add-lesson:hover {
            background: #2a7a8f;
            transform: translateY(-1px);
            color: white;
        }
        

        .btn-back-module {
            background: linear-gradient(135deg, #33b565, #2a8f4f);
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
        
        .btn-back-module:hover {
            background: linear-gradient(135deg, #2a8f4f, #1f5f4f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(51, 156, 181, 0.3);
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
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #339CB5;
            box-shadow: 0 0 0 0.2rem rgba(51, 156, 181, 0.25);
        }
        
        .form-text {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
            color: #6c757d;
            font-weight: 600;
        }
        
        .input-group .form-control {
            border-left: none;
        }
        
        .input-group:focus-within .input-group-text {
            border-color: #339CB5;
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
            
            .form-label {
                font-size: 0.95rem;
            }
            
            .form-control, .form-select {
                padding: 0.6rem 0.8rem;
                font-size: 16px; /* Prevents zoom on iOS */
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
            
            .form-label {
                font-size: 0.9rem;
            }
            
            .form-control, .form-select {
                padding: 0.5rem 0.75rem;
            }
            
            .form-text {
                font-size: 0.8rem;
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

        .fa-file-pdf, .fa-file-video {
            font-size: 1.5rem;
        }
    </style>
@endsection

@section('content')
<div class="main-content">
    <!-- Topbar -->
    @include('dashboard.components.header')
    <main class="page-content">
        <div class="lessons-section">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="page-title">Lessons Management</h2>
                            <p class="page-subtitle">{{ $module->course->title }} / {{ $module->title }}</p>
                            <button class="btn-back-module me-2" data-id="{{$module->course_id}}">
                                <i class="fas fa-arrow-left"></i>
                                Back to Modules
                            </button>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <button class="btn-add-lesson me-2" data-id="">
                                <i class="fas fa-plus-circle"></i>
                                {{ $module->lessons->count() == 0 ? 'Add First Lesson' : 'Add New Lesson' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($module->lessons->count() > 0)
            <div class="lessons-table-card">
                <div class="table-header">
                    <h3 class="table-title">All Lessons</h3>
                </div>
                
                <div class="table-responsive">
                    <table id="lessonsTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="40%">Lesson</th>
                                <th class="text-center" width="30%">File</th>
                                <th class="text-center" width="10%">Status</th>
                                <th class="text-center" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="tbody-lesson">
                            @foreach($module->lessons as $item)
                                <tr class="text-center">
                                    <td>{{$item->title}}</td>
                                    <td>
                                        <div class="action-buttons dropdown">
                                            <button class="btn-action btn-file" title="File" data-url="{{$item->file}}" data-type="{{$item->type}}">
                                                <i class="fas fa-file-{{$item->type == 'pdf' ? 'pdf' : 'video'}}"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td><span class="lesson-status {{$item->status == 'active' ? 'status-active' : 'status-inactive'}}">{{$item->status}}</span></td>
                                    <td>
                                        <div class="action-buttons dropdown">
                                            <button class="btn-action btn-lesson-edit" title="Edit" data-id="{{$item->id}}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-action btn-delete" title="Delete" data-id="{{$item->id}}">
                                                <i class="fas fa-trash"></i>
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
            <div class="lessons-table-card">
                <div class="table-header text-center">
                    <h3 class="table-title">No lessons found</h3>
                </div>
            </div>
        @endif
    </main>
</div>

{{-- Add Lesson --}}
<div class="modal fade" id="addLesson" tabindex="-1" aria-labelledby="addLessonLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLessonLabel">
                    <i class="fas fa-plus-circle me-2"></i>
                    <span></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-0">
          <video id="videoPlayer" class="w-100" controls>
            <source src="" type="video/mp4">
            Your browser does not support HTML video.
          </video>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
    <script src="{{ asset('portal/js/dataTable.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#lessonsTable').DataTable({
                "ordering": false
            });

            $('#lessonsTable_wrapper').find('div.dt-layout-row:first').addClass('m-4');
        });

        $(document).on('click', '.btn-back-module', function() {
            var id = $(this).data('id');
            var url = "{{ route('admin.courses.module', ':id') }}"; 
            url = url.replace(':id', id);
            window.location.href = url;
        });

        // Add Lesson
        $(document).on('click', '.btn-add-lesson, .btn-lesson-edit', function() {
            var id = $(this).data('id');
            
            if(id == ''){
                $('#addLesson').find('.modal-title').find('span').text('Add Lesson');
            }
            else{
                $('#addLesson').find('.modal-title').find('span').text('Update Lesson');
            }
            
            $.ajax({
                url: '{{route('admin.courses.lesson.modal')}}',
                type: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    lessonId: id,
                    moduleId: '{{ $module->id }}',
                    course_id: '{{ $module->course_id }}'
                },
                success: function(response) {
                    $('.modal-body').empty();
                    $('.modal-body').html(response);
                    $('#addLesson').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            var tr = $(this).closest('tr');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this lesson?',
                html: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.courses.lesson.delete')}}",
                        type: "POST",
                        data: {
                            _token: "{{csrf_token()}}",
                            id: id
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Lesson deleted successfully',
                                icon: 'success'
                            });
                            tr.remove();

                            if($('.tbody-lesson').find('tr').length == 0) {
                                $('.lessons-table-card').remove();

                                $('.page-content').append(`
                                    <div class="lessons-table-card">
                                        <div class="table-header text-center">
                                            <h3 class="table-title">No lessons found</h3>
                                        </div>
                                    </div>
                                `);
                            }
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

        $(document).on('click', '.btn-file', function() {
            var url = $(this).data('url');
            var type = $(this).data('type');
            var app_url = '{{ env('APP_URL') }}';
            if(type == 'pdf') {
                window.open( url, "_blank");
            }
            else if(type == 'video') {
                window.open( app_url + url, "_blank");
            }
        });
    </script>
@endsection