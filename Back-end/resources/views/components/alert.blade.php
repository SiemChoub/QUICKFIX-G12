{{-- <div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
    <div id="alert" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 px-4 py-2 bg-blue-500 text-white rounded shadow-md">
        {{ $message }}
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                document.getElementById('alert').style.display = 'none';
            }, 5000);
        });
    </script>
    
</div> --}}


<div id="alert" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 px-4 py-2 bg-blue-500 text-white rounded shadow-md">
    {{ $message }}
</div>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hide the alert after 5 seconds
        setTimeout(function () {
            document.getElementById('alert').style.display = 'none';
        }, 5000);

     
    });
</script>
