@extends('dashboard')

@section('title', 'Course | EverGreen Freelancing')

@section('css')
    <style>
        /* Course Content Page Specific Styles */
        .course-content-section {
            padding: 2rem 0;
        }
        
        .course-header {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .course-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }
        
        .course-subtitle {
            color: #666;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        
        .course-progress-overview {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .progress-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }
        
        .progress-stat {
            text-align: center;
        }
        
        .progress-stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #339CB5;
        }
        
        .progress-stat-label {
            font-size: 0.8rem;
            color: #666;
            margin-top: 0.25rem;
        }
        
        .modules-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .modules-header {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            color: white;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .modules-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
        }
        
        .course-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .sidebar-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-card h4 {
            color: #333;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        
        /* Module Styles */
        .module {
            border-bottom: 1px solid #e9ecef;
        }
        
        .module:last-child {
            border-bottom: none;
        }
        
        .module-header {
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f8f9fa;
        }
        
        .module-header:hover {
            background: #e9ecef;
        }
        
        .module-header.active {
            background: #e3f2fd;
            border-left: 4px solid #339CB5;
        }
        
        .module-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }
        
        .module-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            color: white;
            font-size: 1.1rem;
        }
        
        .module-details h5 {
            margin: 0;
            font-weight: 600;
            color: #333;
            font-size: 1rem;
        }
        
        .module-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.25rem;
            font-size: 0.8rem;
            color: #666;
        }
        
        .module-toggle {
            background: none;
            border: none;
            color: #666;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }
        
        .module-toggle.rotated {
            transform: rotate(180deg);
        }
        
        .module-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .module-content.expanded {
            max-height: 2000px;
        }
        
        
        .lesson-materials {
            padding: 1.5rem;
        }
        
        .materials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
        
        .material-item {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .material-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }
        
        .material-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }
        
        .material-icon {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: white;
        }
        
        .material-icon.pdf {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        
        .material-icon.video {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
        }
        
        .material-icon.document {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }
        
        .material-title {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
            margin: 0;
        }
        
        .material-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #666;
        }
        
        .material-duration {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .material-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }
        
        .btn-material {
            flex: 1;
            padding: 0.5rem 0.75rem;
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
        }
        
        .btn-play {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            color: white;
        }
        
        .btn-play:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            color: white;
        }
        
        .btn-download {
            background: #f8f9fa;
            color: #495057;
            border: 1px solid #e9ecef;
        }
        
        .btn-download:hover {
            background: #e9ecef;
            color: #495057;
        }
        
        /* Progress Bar */
        .progress-bar-container {
            background: #e9ecef;
            border-radius: 10px;
            height: 8px;
            overflow: hidden;
            margin: 1rem 0;
        }
        
        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #339CB5, #2a7a8f);
            border-radius: 10px;
            transition: width 0.3s ease;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            
            .course-sidebar {
                order: -1;
            }
            
            .course-header {
                padding: 1.5rem;
            }
            
            .course-title {
                font-size: 1.5rem;
            }
            
            .progress-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .module-header {
                padding: 1rem;
            }
            
            .lesson-materials {
                padding: 1rem;
            }
            
            .materials-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .course-content-section {
                padding: 1rem 0;
            }
            
            .course-header {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .course-title {
                font-size: 1.3rem;
            }
            
            .progress-stats {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .module-header {
                padding: 0.75rem;
            }
            
            .lesson-materials {
                padding: 0.75rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="main-content">
    <!-- Topbar -->
    @include('dashboard.components.header')

    <main class="page-content">
                <div class="course-content-section">
                    <div class="container-fluid">

                        <!-- Course Content Layout -->
                        <div class="course-content-layout">
                            <!-- Modules Container -->
                            <div class="modules-container">
                                <div class="modules-header">
                                    <h3 class="modules-title">
                                        <i class="fas fa-list-ul me-2"></i>
                                        Course Modules
                                    </h3>
                                    <span class="badge bg-light text-dark">{{$course->modules->count()}} Modules</span>
                                </div>
                                
                                @foreach($course->modules as $module)
                                    <div class="module">
                                        <div class="module-header" onclick="toggleModule('module{{$module->id}}')">
                                            <div class="module-info">
                                                <div class="module-icon">
                                                    <i class="fas fa-book"></i>
                                                </div>
                                                <div class="module-details">
                                                    <h5>{{$module->title}}</h5>
                                                    <div class="module-meta">
                                                        <span><i class="fas fa-book"></i> {{$module->lessons->count()}} Lessons</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="module-toggle" id="module{{$module->id}}-toggle">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </div>
                                        <div class="module-content" id="module{{$module->id}}-content">
                                            <div class="lesson-materials">
                                                <div class="materials-grid">
                                                    @foreach($module->lessons as $lesson)
                                                        <div class="material-item">
                                                            <div class="material-header">
                                                                <div class="material-icon video">
                                                                    <i class="fas fa-{{$lesson->type == 'pdf' ? 'file-pdf' : 'play'}}"></i>
                                                                </div>
                                                                <h6 class="material-title">{{$lesson->title}}</h6>
                                                            </div>
                                                            <div class="material-meta">
                                                                <span>{{$lesson->type}}</span>
                                                            </div>
                                                            <div class="material-actions">
                                                                <a href="{{ route('dashboard.lesson.file', $lesson->id) }}" class="btn-material btn-play" target="_blank">
                                                                    <i class="fas fa-{{$lesson->type == 'pdf' ? 'file-pdf' : 'play'}}"></i>
                                                                    {{$lesson->type == 'pdf' ? 'View' : 'Play'}}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </main>
</div>
@endsection

@section('scripts')

<script>
// Module Toggle Functionality
function toggleModule(moduleId) {
    const content = document.getElementById(moduleId + '-content');
    const toggle = document.getElementById(moduleId + '-toggle');
    const header = toggle.closest('.module-header');
    
    if (content.classList.contains('expanded')) {
        content.classList.remove('expanded');
        toggle.classList.remove('rotated');
        header.classList.remove('active');
    } else {
        content.classList.add('expanded');
        toggle.classList.add('rotated');
        header.classList.add('active');
    }
}
</script>
@endsection