# ThinkPlugsWechat for ThinkAdmin

[![Latest Stable Version](https://poser.pugx.org/zoujingli/think-plugs-wechat/v/stable)](https://packagist.org/packages/zoujingli/think-plugs-wechat)
[![Latest Unstable Version](https://poser.pugx.org/zoujingli/think-plugs-wechat/v/unstable)](https://packagist.org/packages/zoujingli/think-plugs-wechat)
[![Total Downloads](https://poser.pugx.org/zoujingli/think-plugs-wechat/downloads)](https://packagist.org/packages/zoujingli/think-plugs-wechat)
[![Monthly Downloads](http://img.shields.io/packagist/dm/zoujingli/think-plugs-wechat.svg)](https://packagist.org/packages/zoujingli/think-plugs-wechat)
[![License](https://poser.pugx.org/zoujingli/think-plugs-wechat/license)](https://packagist.org/packages/zoujingli/think-plugs-wechat)

**ThinkAdmin** 后台微信插件，微信基础管理模块，开源免费可商用！

代码主仓库放在`Gitee`，`Github`仅为镜像仓库用于发布`Composer`包。

安装此插件会占用并替换 `app/wechat` 目录 ( 先删再写 )，若有对 `app/wechat` 有修改不建议安装此插件，否则会造成修改的内容丢失！

使用 `Composer` 卸载此插件时，不会删除 `app/wechat` 目录和对应数据表，需要手动删除目录和数据表。

如果不希望自有的 `app/wechat` 目录被更新替换，可以在 `app/wechat` 目录下创建 `ignore` 文件（ 即 `app/wechat/ignore`，注意文件没有后缀哦！），即使执行了插件安装或更新都会忽略更新替换。

### 安装插件

```shell
# 注意，插件仅支持在 ThinkAdmin v6 系统中使用
composer require zoujingli/think-plugs-wechat
```

### 卸载插件

```shell
# 插件卸载不会删除数据表和 app/wechat 的代码
# 卸载后通过 composer update 时不会再更新，其他依赖除外
composer remove zoujingli/think-plugs-wechat
```

### 功能节点

可根据下面的功能节点配置菜单和访问权限，按钮操作级别的节点未展示！

* 微信接口配置：`wechat/config/options`
* 微信支付配置：`wechat/config/payment`
* 微信粉丝管理：`wechat/fans/index`
* 微信图文管理：`wechat/news/index`
* 微信菜单配置：`wechat/menu/index`
* 回复规则管理：`wechat/keys/index`
* 关注自动回复：`wechat/auto/index`

### 插件数据库

本插件涉及数据表有：

* 微信-回复：`wechat_auto`
* 微信-粉丝：`wechat_fans`
* 微信-标签：`wechat_fans_tags`
* 微信-规则：`wechat_keys`
* 微信-素材：`wechat_media`
* 微信-图文：`wechat_news`
* 微信-文章：`wechat_news_article`

### 版权说明

**ThinkPlugsWechat** 遵循`MIT`开源协议发布，并免费提供使用。

本项目包含的第三方源码和二进制文件的版权信息将另行标注，请在对应文件查看。

版权所有 Copyright © 2014-2023 by ThinkAdmin (https://thinkadmin.top) All rights reserved。
