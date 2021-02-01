<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<table><tr>
        <td>
            <table>
                <!-- Email Header -->
                @include('emails.layouts.header')
                <!-- /Email Header -->

                <!-- Email Containt -->
                @yield('content')
                <!-- /Email Containt -->

                <!-- Email Footer -->
                @include('emails.layouts.footer')
                <!-- /Email Footer -->
            </table>
        </td>
    </tr></table>
</body>
</html>
