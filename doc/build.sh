#!/bin/bash

echo '<link href="markdown.css" rel="stylesheet">' > api.html
pandoc -f markdown -t html ApiDoc.md  >> api.html
