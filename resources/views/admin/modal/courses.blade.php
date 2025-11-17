<table class="table table-hover">
    <thead>
        <tr>
            <th>Course</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
            <tr>
                <td><i class="fas fa-book me-2"></i><span class="fw-bold">{{ $course->course->title }}</span></td>
            </tr>
        @endforeach
    </tbody>
</table>