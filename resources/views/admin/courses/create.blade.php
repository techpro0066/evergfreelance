@extends('dashboard')

@section('title', 'Create Course - EverGreen Freelancing')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <style>
        .course-form-section { padding: 2rem 0; }
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .form-header {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .form-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .form-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }
        .form-body { padding: 2rem; }
        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #e9ecef;
        }
        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .section-title {
            color: #333;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            display: block;
        }
        .form-control, .form-select, .form-textarea {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        .form-control:focus, .form-select:focus, .form-textarea:focus {
            border-color: #339CB5;
            box-shadow: 0 0 0 0.2rem rgba(51, 156, 181, 0.25);
            outline: none;
        }
        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }
        .image-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: #f8f9fa;
        }
        .image-upload-area:hover {
            border-color: #339CB5;
            background: rgba(51, 156, 181, 0.05);
        }
        .upload-icon {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }
        .upload-text {
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        .upload-hint {
            font-size: 0.85rem;
            color: #adb5bd;
        }
        .preview-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 1rem;
        }
        .price-input-group {
            position: relative;
        }
        .price-symbol {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-weight: 600;
        }
        .price-input {
            padding-left: 2rem;
        }
        .form-check {
            margin-bottom: 0.75rem;
        }
        .form-check-input:checked {
            background-color: #339CB5;
            border-color: #339CB5;
        }
        .form-check-label {
            font-weight: 500;
            color: #555;
        }
        .btn-submit {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(51, 156, 181, 0.3);
            color: white;
        }
        .btn-submit:disabled {
            background: #6c757d;
            cursor: not-allowed;
            opacity: 0.6;
            transform: none;
        }
        .btn-submit:disabled:hover {
            background: #6c757d;
            transform: none;
            box-shadow: none;
        }
        .btn-cancel {
            background: #6c757d;
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 1rem;
        }
        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            color: white;
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
        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 1rem;
        }
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }
        .character-count {
            font-size: 0.85rem;
            color: #6c757d;
            text-align: right;
            margin-top: 0.25rem;
        }
        .character-count.warning { color: #ffc107; }
        .character-count.danger { color: #dc3545; }
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .course-form-section { padding: 1rem 0; }
            .form-header { padding: 1.5rem; }
            .form-title { font-size: 1.5rem; }
            .form-body { padding: 1.5rem; }
            .form-section {
                margin-bottom: 1.5rem;
                padding-bottom: 1.5rem;
            }
            .section-title {
                font-size: 1.2rem;
                margin-bottom: 1rem;
            }
            .form-control, .form-select, .form-textarea {
                padding: 0.875rem 1rem;
                font-size: 16px;
            }
            .image-upload-area { padding: 1.5rem; }
            .upload-icon { font-size: 2.5rem; }
            .btn-submit, .btn-cancel {
                padding: 1rem 1.5rem;
                font-size: 1rem;
            }
            .form-check { margin-bottom: 0.5rem; }
        }
        
        @media (max-width: 576px) {
            .form-header { padding: 1rem; }
            .form-body { padding: 1rem; }
            .form-title { font-size: 1.3rem; }
            .section-title { font-size: 1.1rem; }
            .image-upload-area { padding: 1rem; }
            .upload-icon { font-size: 2rem; }
        }

        .dropify-wrapper .dropify-message p {
            font-size: 18px !important;
        }

        .dropify {
            height: 100% !important;
        }

        #videoProgressBar {
            width: 100%;
            height: 12px;
            background: linear-gradient(90deg, #e2e8f0 0%, #f1f5f9 100%);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #cbd5e1;
            margin-top: 1rem;
        }

        #videoProgressBar::-webkit-progress-bar {
            background: linear-gradient(90deg, #e2e8f0 0%, #f1f5f9 100%);
            border-radius: 10px;
        }

        #videoProgressBar::-webkit-progress-value {
            background: linear-gradient(90deg, #339CB5 0%, #2a7a8f 50%, #1f5f6f 100%);
            border-radius: 10px;
            transition: width 0.3s ease-in-out;
            box-shadow: 0 2px 4px rgba(51, 156, 181, 0.3);
        }

        #videoProgressBar::-moz-progress-bar {
            background: linear-gradient(90deg, #339CB5 0%, #2a7a8f 50%, #1f5f6f 100%);
            border-radius: 10px;
        }

        #videoProgressText {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-top: 8px;
            text-align: center;
            background: linear-gradient(90deg, #339CB5, #2a7a8f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .video-progress-container {
            display: none;
        }
    </style>
@endsection

@section('content')
<div class="main-content">
    @include('dashboard.components.header')
    <main class="page-content">
        <div class="course-form-section">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <div class="form-card">
                            <!-- Form Header -->
                            <div class="form-header">
                                <h2 class="form-title">{{ is_null($course) ? 'Add New Course' : 'Edit Course' }}</h2>
                                <p class="form-subtitle">Create a comprehensive course for your students</p>
                            </div>
                            
                            <!-- Form Body -->
                            <div class="form-body">
                                <!-- Alert Messages -->
                                <div id="alertContainer"></div>
                                
                                <form id="courseForm" action="{{ route('admin.courses.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Basic Information -->
                                    <div class="form-section">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label required-field">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                        <option value="active" selected>Active</option>
                                                        <option value="inactive" {{$course != null ? ($course->status == 'inactive' ? 'selected' : '') : ''}}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label required-field">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title" value="{{  $course != null ? old('title', $course->title) : old('title')}}" placeholder="Title">
                                                    <input type="hidden" name="id" value="{{ $course->id ?? null }}">
                                                    @error('title')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="header" class="form-label required-field">Header</label>
                                                    <textarea class="form-control form-textarea" id="header" name="header" rows="4" placeholder="Header">{{ $course != null ? old('header', $course->header) : old('header') }}</textarea>
                                                    @error('header')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="description" class="form-label required-field">Description</label>
                                                    <textarea class="form-control form-textarea ckplot" id="description" name="description" rows="4" placeholder="Describe what students will learn in this course...">{{ $course != null ? old('description', $course->description) : old('description') }}</textarea>
                                                    @error('description')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="thumbnail" class="form-label required-field">Thumbnail</label>
                                                    <input type="file" class="form-control dropify" id="thumbnail" name="thumbnail" data-max-file-size="5M" data-allowed-file-extensions="jpg jpeg png" @if(!is_null($course)) data-default-file="{{ asset($course->thumbnail) }}" @endif>
                                                    @error('thumbnail')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Video</label>
                                                    <input type="file" class="form-control dropify video-file" id="video" name="video" data-max-file-size="200M" data-allowed-file-extensions="mp4" @if(!is_null($course->video)) data-default-file="{{ asset($course->video) }}" @endif>
                                                    <input type="hidden" name="video_file_path" value="{{ $course != null ? $course->video : '' }}">
                                                    <div class="video-progress-container">
                                                        <progress id="videoProgressBar" value="0" max="100"></progress>
                                                        <p id="videoProgressText">0%</p>
                                                    </div>
                                                    @error('video')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                @if(!is_null($course->video))
                                                {{-- Icon with view icon --}}
                                                    <div class="mb-3 d-flex align-items-center gap-2">
                                                        <i class="fas fa-eye text-primary" style="font-size: 20px;"></i>
                                                        <a href="{{ asset($course->video) }}" target="_blank">View Video</a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="price" class="form-label required-field">Price</label>
                                                    <input type="text" class="form-control price" id="price" name="price" value="{{ $course != null ? old('price', $course->price) : old('price') }}" placeholder="Price">
                                                    <input type="hidden" name="old_thumbnail" value="{{ $course != null ? $course->thumbnail : '' }}">
                                                    <input type="hidden" name="old_video" value="{{ $course != null ? $course->video : '' }}">
                                                    @error('price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Form Actions -->
                                    <div class="form-section">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="button" class="btn-cancel">
                                                    <i class="fas fa-times me-2"></i>Cancel
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn-submit" id="submitBtn">
                                                    <i class="fas fa-save me-2"></i>{{ is_null($course) ? 'Create Course' : 'Update Course' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/super-build/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();

            if($('.ckplot').length>0){
                $('.ckplot').each(function(){
                    CKEDITOR.ClassicEditor.create(document.getElementById($(this).attr('id')), {
                        // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                        toolbar: {
                            items: [
                                'findAndReplace', 'selectAll', '|',
                                'heading', '|',
                                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                                'bulletedList', 'numberedList', 'todoList', '|',
                                'outdent', 'indent', '|',
                                'undo', 'redo',
                                '-',
                                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                                'alignment', '|',
                                'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                                'textPartLanguage', '|',
                                'sourceEditing'
                            ],
                            shouldNotGroupWhenFull: true
                        },
                        // Changing the language of the interface requires loading the language file using the <script> tag.
                        // language: 'es',
                        list: {
                            properties: {
                                styles: true,
                                startIndex: true,
                                reversed: true
                            }
                        },
                        // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                            ]
                        },
                        // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                        placeholder: 'Welcome to CKEditor 5!',
                        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                        fontFamily: {
                            options: [
                                'default',
                                'Arial, Helvetica, sans-serif',
                                'Courier New, Courier, monospace',
                                'Georgia, serif',
                                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                                'Tahoma, Geneva, sans-serif',
                                'Times New Roman, Times, serif',
                                'Trebuchet MS, Helvetica, sans-serif',
                                'Verdana, Geneva, sans-serif'
                            ],
                            supportAllValues: true
                        },
                        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                        fontSize: {
                            options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                            supportAllValues: true
                        },
                        // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                        // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                        htmlSupport: {
                            allow: [
                                {
                                    name: /.*/,
                                    attributes: true,
                                    classes: true,
                                    styles: true
                                }
                            ]
                        },
                        // Be careful with enabling previews
                        // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                        htmlEmbed: {
                            showPreviews: true
                        },
                        // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                        link: {
                            decorators: {
                                addTargetToExternalLinks: true,
                                defaultProtocol: 'https://',
                                toggleDownloadable: {
                                    mode: 'manual',
                                    label: 'Downloadable',
                                    attributes: {
                                        download: 'file'
                                    }
                                }
                            }
                        },
                        // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                        mention: {
                            feeds: [
                                {
                                    marker: '@',
                                    feed: [
                                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                        '@sugar', '@sweet', '@topping', '@wafer'
                                    ],
                                    minimumCharacters: 1
                                }
                            ]
                        },
                        // The "superbuild" contains more premium features that require additional configuration, disable them below.
                        // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                        removePlugins: [
                            // These two are commercial, but you can try them out without registering to a trial.
                            // 'ExportPdf',
                            // 'ExportWord',
                            'AIAssistant',
                            'CKBox',
                            'CKFinder',
                            'EasyImage',
                            // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                            // Storing images as Base64 is usually a very bad idea.
                            // Replace it on production website with other solutions:
                            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                            // 'Base64UploadAdapter',
                            'RealTimeCollaborativeComments',
                            'RealTimeCollaborativeTrackChanges',
                            'RealTimeCollaborativeRevisionHistory',
                            'PresenceList',
                            'Comments',
                            'TrackChanges',
                            'TrackChangesData',
                            'RevisionHistory',
                            'Pagination',
                            'WProofreader',
                            // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                            // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                            'MathType',
                            // The following features are part of the Productivity Pack and require additional license.
                            'SlashCommand',
                            'Template',
                            'DocumentOutline',
                            'FormatPainter',
                            'TableOfContents',
                            'PasteFromOfficeEnhanced',
                            'CaseChange'
                        ]
                    });
                });
                setTimeout(function() {
                  $('.ckplot.d-none').each(function(){
                    $(this).next().addClass('d-none');
                  }) 
                },2000)
            }
        });

        // Track if form was successfully submitted to avoid deleting saved videos
        var formSubmitted = false;
        
        // Function to cleanup uploaded video file if form wasn't submitted
        function cleanupUnsubmittedVideo(useFetchKeepalive) {
            if(formSubmitted) return; // Don't delete if form was submitted
            
            var videoFilePath = $('input[name="video_file_path"]').val();
            var oldVideo = $('input[name="old_video"]').val();
            var isEditMode = $('input[name="id"]').length > 0 && $('input[name="id"]').val() != '';
            
            // Only delete if:
            // 1. There's a new uploaded video (video_file_path exists)
            // 2. It's different from the old video (new upload)
            // 3. Form wasn't submitted
            if(videoFilePath && videoFilePath != '' && videoFilePath != oldVideo) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();
                var deleteData = {
                    file_url: videoFilePath,
                    id: isEditMode ? $('input[name="id"]').val() : ''
                };
                
                if(useFetchKeepalive) {
                    // Use fetch with keepalive for beforeunload (more reliable than axios)
                    var formData = new FormData();
                    formData.append('file_url', deleteData.file_url);
                    if(deleteData.id) formData.append('id', deleteData.id);
                    formData.append('_token', csrfToken);
                    
                    fetch('/delete-course-file', {
                        method: 'POST',
                        body: formData,
                        keepalive: true // Ensures request completes even if page unloads
                    }).catch(function(error) {
                        console.error('Error cleaning up video file on unload:', error);
                    });
                } else {
                    // Use axios for cancel button (allows proper error handling)
                    axios({
                        method: 'delete',
                        url: "/delete-course-file",
                        data: deleteData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    }).then(function(response) {
                        console.log('Unsubmitted video file cleaned up successfully');
                    }).catch(function(error) {
                        console.error('Error cleaning up video file:', error);
                    });
                }
            }
        }
        
        $(document).on('click', '.btn-cancel', function(e){
            e.preventDefault();
            cleanupUnsubmittedVideo(false);
            // Small delay to allow cleanup request to complete
            setTimeout(function() {
                window.location.href = "{{ route('admin.courses') }}";
            }, 300);
        });
        
        // Cleanup on page unload (user closes tab/refreshes without submitting)
        $(window).on('beforeunload', function() {
            cleanupUnsubmittedVideo(true); // Use fetch with keepalive for more reliable cleanup
        });

        // Intercept form submission to prevent sending large video file
        // Always remove video file input since we use chunked uploads
        $('#courseForm').on('submit', function(e) {
            var videoFileInput = $('.video-file')[0];
            var hasVideoFile = videoFileInput && videoFileInput.files && videoFileInput.files.length > 0;
            var hasVideoFilePath = $('input[name="video_file_path"]').val() != '';
            
            // If there's a video file in the input, remove it to prevent "post data too large" error
            // We only use video_file_path (from chunked upload) or old_video (when editing)
            if(hasVideoFile || hasVideoFilePath) {
                // Create a new form without the video file input
                var formData = new FormData(this);
                formData.delete('video'); // Remove video file from form data
                
                // Submit form via AJAX to have full control
                e.preventDefault();
                
                var submitBtn = $('#submitBtn');
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...');
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Mark form as submitted to prevent cleanup
                        formSubmitted = true;
                        
                        if(response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            window.location.href = "{{ route('admin.courses') }}";
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>{{ is_null($course) ? "Create Course" : "Update Course" }}');
                        
                        var errors = xhr.responseJSON?.errors || {};
                        var errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                        
                        if(Object.keys(errors).length > 0) {
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                        } else {
                            errorHtml += '<li>An error occurred. Please try again.</li>';
                        }
                        
                        errorHtml += '</ul></div>';
                        $('#alertContainer').html(errorHtml);
                        
                        // Scroll to top to show errors
                        $('html, body').animate({ scrollTop: 0 }, 500);
                    }
                });
                
                return false;
            }
        });

        $(document).on('input','.price',function (e) {
            this.value = this.value.replace(/[^0.00-9.99]/g, '').replace(/(\..*)\./g, '$1').replace(new RegExp("(^[\\d]{50})[\\d]", "g"), '$1');
        });
        
        // Chunked video upload functionality
        $('.video-file').on('change', async function(e) {
            const file = e.target.files[0];
            // Check current state (not initial state)
            var currentIsEditMode = $('input[name="id"]').length > 0 && $('input[name="id"]').val() != '';
            var currentVideoPath = $('input[name="video_file_path"]').val();
            
            if (!file) {
                // If no file selected and no existing video, disable submit for new courses
                if(!currentIsEditMode && !currentVideoPath) {
                    $('#submitBtn').prop('disabled', true);
                }
                return;
            }

            const extension = file.name.split('.').pop();
            if(extension != 'mp4') {
                swal({
                    title: "Error!",
                    text: "Only .mp4 files are allowed",
                    icon: "error"
                });
                // Reset the dropify input
                $('.video-file').dropify('reset');
                // Disable submit button if creating new course (video required)
                if(!currentIsEditMode && !currentVideoPath) {
                    $('#submitBtn').prop('disabled', true);
                }
                return;
            }

            // Disable submit button during upload
            $('#submitBtn').prop('disabled', true);

            // Show progress bar
            $('.video-progress-container').show();
            $('#videoProgressBar').val(0);
            $('#videoProgressText').text('0%');

            const chunkSize = 2 * 1024 * 1024; // 2 MB
            const totalChunks = Math.ceil(file.size / chunkSize);
            let uploaded = 0;

            try {
                for (let i = 0; i < totalChunks; i++) {
                    const start = i * chunkSize;
                    const end = Math.min(start + chunkSize, file.size);
                    const chunk = file.slice(start, end);

                    let formData = new FormData();
                    formData.append("file", chunk);
                    formData.append("fileName", file.name);
                    formData.append("chunkIndex", i);

                    await axios.post("/upload-course-chunk", formData, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
                        },
                        onUploadProgress: (progressEvent) => {
                            let percent = Math.round(((uploaded + progressEvent.loaded) / file.size) * 100);
                            $('#videoProgressBar').val(percent);
                            $('#videoProgressText').text(percent + "%");
                        }
                    });

                    uploaded += chunk.size;
                }

                // After all chunks uploaded → Merge request
                const response = await axios.post("/merge-course-chunks", {
                    fileName: file.name,
                    totalChunks: totalChunks
                }, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
                    }
                });
                
                if(response.data.status === 'merged') {
                    $('input[name="video_file_path"]').val(response.data.path);
                    $('#videoProgressText').text('Upload Complete!');
                    
                    // Clear the file input to prevent sending large file in form submission
                    // This prevents "post data too large" error
                    $('.video-file').dropify('reset');
                    
                    // Enable submit button after successful upload
                    $('#submitBtn').prop('disabled', false);
                    console.log('Video upload complete. Button enabled. Path:', response.data.path);
                    
                    // Hide progress bar after a delay
                    setTimeout(function() {
                        $('.video-progress-container').hide();
                    }, 2000);
                } else {
                    console.error('Merge failed:', response);
                    $('#submitBtn').prop('disabled', false); // Enable button even if merge status unclear
                }
            } catch (error) {
                console.error('Upload error:', error);
                swal({
                    title: "Error!",
                    text: "Video upload failed. Please try again.",
                    icon: "error"
                });
                $('.video-file').dropify('reset');
                $('.video-progress-container').hide();
                $('input[name="video_file_path"]').val('');
                
                // Check current state after error
                var currentIsEditMode = $('input[name="id"]').length > 0 && $('input[name="id"]').val() != '';
                var currentVideoPath = $('input[name="video_file_path"]').val();
                
                // Disable button if creating new course (video required)
                // Keep enabled if editing (video optional)
                if(!currentIsEditMode && !currentVideoPath) {
                    $('#submitBtn').prop('disabled', true);
                } else {
                    $('#submitBtn').prop('disabled', false);
                }
            }
        });

        // Handle file removal
        $(document).on('click', '.dropify-clear', function(e) {
            if($(this).closest('.mb-3').find('.video-file').length > 0) {
                $('#videoProgressBar').val(0);
                $('#videoProgressText').text('0%');
                $('.video-progress-container').hide();
                
                var file_url = $('input[name="video_file_path"]').val();
                if(file_url) {
                    axios({
                        method: 'delete',
                        url: "/delete-course-file",
                        data: {
                            file_url: file_url,
                            id: $('input[name="id"]').val()
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
                        }
                    }).then(function(response) {
                        console.log('Video file deleted successfully');
                    }).catch(function(error) {
                        console.error('Error deleting video file:', error);
                    });
                }
                $('input[name="video_file_path"]').val('');
                
                // Disable submit button when video is removed
                // For new courses, video is required so disable button
                // For editing, video is optional so keep button enabled
                var isEditMode = $('input[name="id"]').length > 0 && $('input[name="id"]').val() != '';
                if(!isEditMode) {
                    $('#submitBtn').prop('disabled', true);
                    console.log('Video removed. Button disabled for new course.');
                } else {
                    $('#submitBtn').prop('disabled', false);
                    console.log('Video removed. Button remains enabled for edit mode.');
                }
            }
        });
    </script>   
@endsection