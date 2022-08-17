<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .text-right {
            text-align: center;

        }

        a {
            text-decoration: none;
        }

        .wrapper {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .coming-soon-info {
            background: url('https://images.unsplash.com/photo-1561758033-d89a9ad46330?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            min-height: calc(100vh - 0px);
            position: relative;
            z-index: 0;
            display: grid;
            padding: 10px 0;
        }

        .coming-soon-info:before {
            content: "";
            background: rgba(0, 0, 0, 0.6);
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: -1;
        }

        .header {
            display: grid;
            align-items: center;
            grid-template-columns: 1fr 1fr;
            grid-gap: 0 10px;
        }

        .coming-soon-info a.brand-logo {
            color: #fff;
            font-weight: 400;
            font-size: 36px;
            text-transform: capitalize;
            position: relative;
            font-family: 'Permanent Marker', cursive;
            letter-spacing: 1px;
        }

        .coming-soon-info .coming-back {
            margin: 0 auto 20px;
            max-width: 600px;
            text-align: center;
            padding: 1em 0;
        }

        .coming-soon-info h1 {
            margin: 0;
            font-size: 70px;
            font-weight: 400;
            color: #ff9800;
            line-height: 95px;
            text-transform: capitalize;
            margin-bottom: 40px;
            font-family: 'Satisfy', cursive;
        }

        .coming-soon-info p.t-text {
            line-height: 26px;
            opacity: 0.9;
            font-family: Poppins;
        }

        .countdown {
            margin: auto;
            display: table;
            font-size: 18px;
            font-weight: 500;

        }

        .coming-soon-info .number {
            font-family: Poppins;
        }

        ::-webkit-input-placeholder {
            font-family: Poppins;
        }

        .coming-soon-info .countdown>div {
            float: left;
            min-width: 100px;
            margin: 40px 10px 0 0;
            font-size: 50px;
            line-height: 70px;
            font-weight: 700;
            color: #fff;
            padding: 0px 15px;
        }

        .coming-soon-info .countdown>div:last-child {
            border-right: none;
        }

        .coming-soon-info p {
            color: #eee;
            font-size: 17px;
            font-weight: 400;
        }

        .coming-soon-info .countdown span {
            position: relative;
            display: block;
            font-size: 12px;
            line-height: 28px;
            text-align: center;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            color: #eee;
        }

        .coming-soon-info input[type="text"] {
            padding: 1em 1.5em;
            border: solid 1px #ffffff;
            width: 88%;
            margin-right: 10px;
            font-size: 17px;
            color: #999999;
            outline: none;
            display: inline-block;
            background: #ffffff;
            border-radius: 6px;
        }

        .coming-soon-info form {
            max-width: 500px;
            margin: 0 50px;
            margin-top: 40px;
            display: flex;
        }

        button {
            color: #fff;
            padding: 1em 1.5em;
            font-size: 17px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            background: #ff9800;
            border: 1px solid #ff9800;
            transition: 0.3s all;
            border-radius: 6px;
        }

        button:hover {
            background: #e98c03;
        }

        #demo {
            margin: 0 0 20px;
            color: #FFFFFF;
            font-size: 30px;
        }
    </style>
</head>


<body>
    <div class="coming-soon-info">
        <div class="wrapper">
            <div class="header">
                <div class="logo">
                    <a class="brand-logo" href="/">Jollof.com</a>
                </div>

            </div>
            <div class="coming-back">
                <h1>CURRENTLY IN MAINTENANCE MODE</h1>
                <p id="demo"></p>
                <!-- <object data='https://www.youtube.com/embed/nfk6sCzRTbM?autoplay=1' width='100%' height='280px'> -->
                <!-- </object> -->
                <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/3a4bg6UO8eQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->

                <script>
                    // Set the date we're counting down to
                    // var countDownDate = new Date("Apr 8, 2022 7:00:00").getTime();

                    // Update the count down every 1 second
                    var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();

                        // Find the distance between now and the count down date
                        var distance = countDownDate - now;

                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Output the result in an element with id="demo"
                        document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                            minutes + "m " + seconds + "s ";

                        // If the count down is over, write some text
                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById("demo").innerHTML = NewcountDownDate - now;
                        }
                    }, 1000);
                </script>

            </div>
        </div>


</body>


</html>
