#!/bin/bash
echo "CAUTION 1 : 호스트에서 삭제된 파일은 컨테이너에 그대로 남아 있습니다."
echo "CAUTION 2 : 이 스크립트는 wp-content 하위항목의 변경 사항에만 유효합니다."
container="wordpress"  # 실제 컨테이너 이름으로 변경
local_path="./src/wp-content"
container_path="/var/www/html"
docker cp -r $local_path/ $container:$container_path
echo "Changes synced to container"
