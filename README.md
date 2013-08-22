P4TQueue
========
This is a queue experiment that might yield some light

## Most Important Prerequisites ##

  * Support for N queues
  * Handling mixed types of messages: strings, arrays, objects
  * With a set of parsable/indexable meta-data
  * Every queue should have its own handler which controls the specifics of the queue such as:
    * Queue consumption order
    * Amount of logging
    * Error handling
    * et cetera ... 
    * all inherited from the base queue handler
  * Every queue should have its own storage engine 
  * All storage engines fall-back to MySQL should they not be available for _pushing_ new stuff to the queue
    * Fallback is periodically transported back to the designated storage engine
  * Queue master
    * Knows what queues are present in the system
    * Knows queue states
    * Knows how many workers are working and where
    * Forks new workes if neccessary
    * Has a GUI
