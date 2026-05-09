#!/bin/bash

echo "📦 Đang chuẩn bị push lên GitHub..."

git add .

echo ""
read -p "✏️  Mô tả thay đổi: " msg

if [ -z "$msg" ]; then
  msg="Update $(date '+%d/%m/%Y %H:%M')"
fi

git commit -m "$msg"
git push

echo ""
echo "✅ Push thành công lên GitHub!"
