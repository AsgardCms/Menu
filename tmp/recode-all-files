#!/bin/sh

find . -type f -print | while read f; do
        mv -i "$f" "$f.recode.$$"
        iconv -f iso-8859-1 -t utf-8 < "$f.recode.$$" > "$f"
        rm -f "$f.recode.$$"
done
