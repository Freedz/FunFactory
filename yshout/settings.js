// Flood control time in milliseconds
// After shouting, the user must wait this long to shout again.
// Set higher if you have a problem with spamming (1000 = one second)
var floodTime=0;

// Time between refreshes (minimum) in milliseconds
// Note that since 1.08, this option will have less of an effect on performance,
// hence the default value is very low :)
var refreshTime=150;

// Check for duplicate instances?
// This can improve performance in some cases.
// However, it may not work on all browsers, resulting in shoutboxes that take
// many seconds to load, even without duplicates.
var checkDuplicates=false;

// Amount of time to hold a duplicate open
// Should be set to approximately var updateTimeout+refreshTime+5 (in seconds)
var duplicateWait=25;
