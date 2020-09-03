## DATALEAD
广告数据监控客户端转化

### 客户端启动接口
GET https://localhost/api/listen/app_init/{app_id}
客户端启动时提交
#### 规则
键|必填|说明
:---:|:---:|:---
reid|是|客户端初始化id PS:客户端初始化时生成的唯一ID, 不考虑删除重装
os|是|0安卓, 1ios, 3其他
imei|否|安卓的设备 ID 
idfa|否|iOS独有的标识符
androidid|否|安卓id原值
oaid|否|Android Q及更高版本的设备号
mac|否|移动设备mac地址
`以下为保留键`|-|-
imei2|否|安卓的设备 ID (双卡双待手机, 卡2 IMEI)
meid|否|移动终端标识号
deviceId|否|手机设备的串号
serial|否|Serial Number 串号
manufacturer|否|制造商
model|否|型号
brand|否|品牌
device|否|设备名
