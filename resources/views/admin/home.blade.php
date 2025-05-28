@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Scheduled Posts Calendar</h2>
    <div id="calendar"></div>
</div>
@endsection

@section('scripts')
<!-- FullCalendar Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            events: @json($posts->map(fn($post) => [
                'title' => $post->title,
                'start' => $post->scheduled_time,
                'color' => $post->status === 'posted' ? 'green' : 'orange'
            ])),
        });

        calendar.render();
    });
</script>
@endsection

