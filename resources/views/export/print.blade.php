<!DOCTYPE html>
<html>
<head>
    <title>Print Receipt</title>
    <script>
        window.onload = function() {
            window.print(); // Automatically open the print dialog
        };
</script>
    </script>
</head>
<body>
    {!! $content !!}
</body>
</html>