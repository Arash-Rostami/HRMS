<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HTMX Example</title>
    <script src="https://unpkg.com/htmx.org"></script>
</head>
<body>
<h1>Welcome to My HTMX Page</h1>
<button hx-get="fetch-data.html" hx-trigger="click" hx-target="#dynamic-content">
    Load Content
</button>
<div id="dynamic-content">
    <!-- Content fetched from fetch-data.html will be loaded here -->
</div>
</body>
</html>
