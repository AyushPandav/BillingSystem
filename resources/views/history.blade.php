<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bills History</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 16px;
        }

        .container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 24px;
            width: 100%;
            max-width: 900px;
        }

        h1 {
            font-size: 28px;
            color: #333;
            text-align: center;
            margin-bottom: 24px;
        }

        .nav-link {
            display: block;
            text-align: right;
            margin-bottom: 16px;
        }

        .nav-link a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .nav-link a:hover {
            text-decoration: underline;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        td {
            color: #555;
        }

        .items-list {
            margin-top: 8px;
            padding-left: 20px;
            font-size: 14px;
            color: #555;
        }

        .no-bills {
            text-align: center;
            color: #777;
            padding: 12px;
        }

        @media (max-width: 600px) {
            .table-container {
                max-height: 300px;
            }

            th, td {
                font-size: 14px;
                padding: 8px;
            }

            h1 {
                font-size: 24px;
            }

            .items-list {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-link">
            <a href="{{ route('billing.index') }}">Back to Billing</a>
        </div>
        <h1>Bills History</h1>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Bill ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bills as $bill)
                        <tr>
                            <td>{{ $bill->id }}</td>
                            <td>{{ $bill->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>${{ number_format($bill->total, 2) }}</td>
                            <td>
                                <ul class="items-list">
                                    @foreach ($bill->items as $item)
                                        <li>{{ $item->name }} (Qty: {{ $item->quantity }}, Price: ${{ number_format($item->price, 2) }})</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="no-bills">No bills found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
