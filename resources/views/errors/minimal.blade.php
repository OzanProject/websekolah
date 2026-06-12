<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
        .error-container {
            max-width: 500px;
            padding: 50px 40px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            width: 90%;
        }
        .error-code {
            font-size: 110px;
            font-weight: 800;
            color: #3b82f6; /* Blue 500 */
            margin: 0;
            line-height: 1;
            letter-spacing: -3px;
            text-shadow: 2px 2px 0px rgba(59, 130, 246, 0.2);
        }
        .error-title {
            font-size: 26px;
            font-weight: 600;
            color: #1e293b;
            margin: 20px 0 10px;
        }
        .error-message {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 35px;
            line-height: 1.6;
        }
        .btn-wrapper {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        .btn {
            display: inline-block;
            padding: 12px 28px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
            font-size: 15px;
        }
        .btn-primary {
            background-color: #3b82f6;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.4);
        }
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px -1px rgba(59, 130, 246, 0.5);
        }
        .btn-secondary {
            background-color: #f1f5f9;
            color: #475569;
        }
        .btn-secondary:hover {
            background-color: #e2e8f0;
            color: #1e293b;
            transform: translateY(-2px);
        }
        /* Color variations for specific errors */
        .code-403 { color: #ef4444; text-shadow: 2px 2px 0px rgba(239, 68, 68, 0.2); }
        .code-500 { color: #f59e0b; text-shadow: 2px 2px 0px rgba(245, 158, 11, 0.2); }
    </style>
</head>
<body>
    <div class="error-container">
        <!-- Optional logic to change color based on code -->
        <h1 class="error-code code-@yield('code')">@yield('code')</h1>
        <h2 class="error-title">@yield('title')</h2>
        <p class="error-message">@yield('message')</p>
        
        <div class="btn-wrapper">
            <a href="{{ url('/') }}" class="btn btn-secondary">Beranda</a>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary">Dashboard</a>
        </div>
    </div>
</body>
</html>
