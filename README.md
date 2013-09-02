P4TQueue
========
This is a queue experiment that might yield some light

### Some Stats ###

  * Let push.php run for 5 000 000 entries
  * 10 workers processed (fetched items concurrently, set lock status, unset lock status, mark item as processed) the lot in under 30 minutes.

Awesome

### Prerequisites ###

  * PHP 5.3+ and MongoDB Driver 1.2.6+
  * MongoDB 2.4+
  
### Usage Examples ###

In one terminal instance start and run the push process to add items to a queue. On my mid-2010 mbp I can get 10 000 items pushed to the queue within about 3-4 seconds

```shell
clops@semmel 16:53:27[~/Sites/p4t/P4TQueue] $ php push.php
Adding messages to the queue endlessly, press CNTRL+C to terminate

[x] 10000 messages written to queue; insetion took 3.1271 seconds.  
[x] 20000 messages written to queue; insetion took 3.1998 seconds.  
[x] 30000 messages written to queue; insetion took 3.095 seconds.  
```

In a parallel terminal session start a consumption worker (actually, feel free to do this N times in parallel). On the same MBP I manage to process around 2K records per second per worker. Adding more workers slows down the average per worker throughput, but having more CPU cores helps here. Really.

```
clops@semmel 16:53:53[~/Sites/p4t/P4TQueue] $ php worker.php 
[*] Waiting for messages. To exit press CTRL+C
[x] 1 is done! Memory: 912Kb
[x] 2 is done! Memory: 912Kb
[x] 3 is done! Memory: 912Kb
```

### More Candy? ###

Yes, want to watch the whole process with as little clutter and numbers jumping on the screen as possible? Sure thing:

```
clops@semmel 17:29:02[~/Sites/p4t/P4TQueue] $ php watch.php 
Watching queue with Storage Path: MongoDB Collection queue_awesome, press CNTRL+C to terminate

Queue Size: 154208
Unprocessed: 13968
0.0088 seconds 
```