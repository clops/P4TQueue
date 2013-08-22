<html>
<body>
    <h2>P4T Queue Experiment</h2>
    <p>This is a simple Queue Load experiment I am working on in my semi-spare time :)</p>

    <h3>Preambula</h3>
    <p>The experiment consists of a MongoDB Based Queue engine and a set of workers. Testing some theories in practice, yo!</p>

    <h3>Things you can do</h3>
    <ul>
        <li>Push 10 000 random messages to the queue. In your console use the command: <span style="background-color:#eee"><tt>php push.php</tt></span></li>
        <li>Process the items with a worker. In your console use the command: <span style="background-color:#eee"><tt>php worker.php</tt></span> feel free to start several instances</li>
    </ul>

    <p><strong>Tested with 5 000 000 entries in the base collection, everything flying like charm.</strong></p>

    <h3>General Synopsis</h3>
    <script src="https://gist.github.com/clops/4e9aed1cdeb5141cfe5f.js"></script>
</body>
</html>