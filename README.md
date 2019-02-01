# simplelinkchecker
A simple link checker, using a PHP script as proxy for cross-origin ajax requests.

## Requirements
* a PHP capable server with CURL installed, e.g. your local development server
* a modern browser (I guess you have at least one)

## What it does
It takes a list of URLs in a `textarea` input field (one URL per line) and sends HTTP requests to each of one – utilizing the PHP proxy script `proxy.php` to work around javascript cross-origin limitations. In the output table you will see the returned HTTP status for each URL and – if any – the redirect target sent in HTTP header.

## Why i wrote this
When relaunching customer websites i want to be sure that all old URLs are redirected to their new destinations. This little tool allows to check all the old URLs (from a previously created URL list) in one flow.
Well, i know there are some similar tools available online – often on some ad congested pages – which do the same thing, but I don't like to paste a bunch of URLs in forms on websites I do not trust.

