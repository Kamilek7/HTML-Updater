#!/bin/bash
gh repo list --visibility "public" --json name | jq -c '.[]' | while read -r repo; do 
    full_name=$(echo "$repo" | jq -r '.name'); 
    image_list=$(gh repo view $full_name | grep -oP 'src="\K[^"]+'); 
    gh repo view $full_name --json url,languages,createdAt,sshUrl | jq --arg images "$image_list"  '. + {images: $images}'; 
done | jq -s '.' > test.txt
