#!/bin/bash
git stash
git pull -X theirs
pageDir=$(jq .pagePath config.json)
cd template
touch loadedSettings.json
gh repo list --visibility "public" --json name | jq -c '.[]' | while read -r repo; do 
    full_name=$(echo "$repo" | jq -r '.name'); 
    image_list=$(gh repo view $full_name | grep -oP 'src="\K[^"]+'); 
    gh repo view $full_name --json url,languages,createdAt,name,description | jq --arg images "$image_list"  '. + {images: $images}'; 
done | jq -s '.' > loadedSettings.json
cd ../
python3 mainCode/main.py
python3 mainCode/fromOutputToMainSite.py
cd $pagePath
git push