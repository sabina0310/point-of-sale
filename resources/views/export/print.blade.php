<!DOCTYPE html>
<html>
<head>
    <title>Print Receipt</title>
    <script>
         // Adjust timing if needed
        window.onload = function() {
            setTimeout(function() {
                window.print(); // Automatically open the print dialog
            }, 1000);
        };
</script>
    </script>
</head>
<body>
    {!! $content !!}
</body>
</html>