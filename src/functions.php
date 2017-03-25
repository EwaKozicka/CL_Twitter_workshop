<?php

//loading all Tweets and preparing div to put on the main site

function getTweets($conn, $array) {
    foreach ($array as $tweet) {
        $text = $tweet->getText();
        $date = $tweet->getCreationDate();
        $userId = $tweet->getuserId();
        $nick = User::loadUserById($conn, $userId)->getUsername();
        $fullTweets[] = '<div><span class="tweet_header">'
                . $date . '<a class="plain" href="../controller/tweet.php?name=' . $nick . '"> ' . $nick . '</a> writes: </span><br>'
                . '<span class="text">' . $text . '</span><br>'
                . '<label>Leave a comment:<br>'
                . '<textarea cols ="32" rows="2" name="comment"></textarea></label>'
                . 'Comments: $number <div class="middle"><button class="add" type="submit" name="submit">Add!</button></div>'
                . '<hr></div>';
    }
    rsort($fullTweets);

    return $fullTweets;
}
