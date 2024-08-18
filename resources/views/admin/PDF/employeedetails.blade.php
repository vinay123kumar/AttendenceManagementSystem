<!DOCTYPE html>
<html>
<head>
    <title>Employee List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0e0e0;
        }
        td {
            border-bottom: 1px solid #ddd;
        }
        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                border: 1px solid #ddd;
                margin-bottom: 10px;
                display: block;
            }
            td {
                border-bottom: 1px solid #ddd;
                position: relative;
                padding-left: 50%;
                text-align: right;
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 10px;
                font-weight: bold;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <h2>Employee List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Position</th>
                <th>Email</th>
                <th>Schedule</th>
                <th>Member Since</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                        @if(isset($employee->schedules->first()->slug))
                        {{ $employee->schedules->first()->slug }}
                        @endif
                    </td>
                    <td>{{ $employee->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
