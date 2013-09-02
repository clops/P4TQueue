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