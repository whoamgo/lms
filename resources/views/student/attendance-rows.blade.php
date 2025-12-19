@forelse($attendances as $attendance)
    <tr>
        <td>{{ $attendance->created_at->format('d M Y') }}</td>
        <td>{{ $attendance->created_at->format('D') }}</td>
        <td>
            @if($attendance->status === 'present')
                <span style="color: #4ade80;">• Present</span>
            @elseif($attendance->status === 'absent')
                <span style="color: #ef4444;">• Absent</span>
            @elseif($attendance->status === 'late')
                <span style="color: #fb923c;">• Late</span>
            @else
                <span style="color: #fb923c;">• Recorded</span>
            @endif
        </td>
        <td>
            @if($attendance->marked_at)
                {{ $attendance->marked_at->format('h:i A') }}
            @else
                -
            @endif
        </td>
        <td>
            @if($attendance->marked_at && $attendance->liveClass)
                @php
                    $checkOut = $attendance->marked_at->copy()->addHours(8)->addMinutes(30);
                @endphp
                {{ $checkOut->format('h:i A') }}
            @else
                -
            @endif
        </td>
        <td>
            @if($attendance->marked_at)
                8h 30m
            @else
                -
            @endif
        </td>
        <td>
            @if($attendance->status === 'present')
                On Time
            @elseif($attendance->status === 'late')
                Late
            @elseif($attendance->status === 'absent')
                Absent
            @else
                Weekend
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" style="text-align: center; padding: 40px; color: #6b7280;">
            No more attendance records found.
        </td>
    </tr>
@endforelse
