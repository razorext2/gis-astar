{{-- Goal: PDF export template, Livewire: None, Alpine: None --}}
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; margin: 15px; }
        h2 { color: #881b1b; font-size: 18px; margin-bottom: 2px; }
        .date { color: #666; font-size: 10px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background-color: #f9f9f9; font-weight: bold; border-bottom: 2px solid #ddd; }
        tr:nth-child(even) { background-color: #fcfcfc; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <div class="date">Dicetak pada: {{ now()->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y H:i') }} WIB</div>
    <table>
        <thead>
            <tr>
                @foreach ($headings as $heading)
                    <th>{{ ucfirst(str_replace('_', ' ', $heading)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $val)
                        <td>
                            @if (is_array($val))
                                {{ json_encode($val) }}
                            @else
                                {{ $val }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
