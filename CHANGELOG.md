# Changelog

## [1.5.0](https://github.com/sumup/sumup-ecom-php-sdk/compare/v1.4.0...v1.5.0) (2025-11-20)


### Features

* **ci:** install deps via composer ([#75](https://github.com/sumup/sumup-ecom-php-sdk/issues/75)) ([5b7e1bc](https://github.com/sumup/sumup-ecom-php-sdk/commit/5b7e1bc9a62e93968de60017f5e1382c3a319a22))
* **tooling:** configure dependabot ([#76](https://github.com/sumup/sumup-ecom-php-sdk/issues/76)) ([0b41fa6](https://github.com/sumup/sumup-ecom-php-sdk/commit/0b41fa621baa48e65bbc41d2922141061a39ad3c))


### Miscellaneous Chores

* **deps-dev:** update friendsofphp/php-cs-fixer requirement ([#79](https://github.com/sumup/sumup-ecom-php-sdk/issues/79)) ([0133559](https://github.com/sumup/sumup-ecom-php-sdk/commit/01335594a4a6e7457de3f51449e0dbb8b2f304ec))
* **deps:** bump actions/checkout from 5.0.0 to 5.0.1 ([#78](https://github.com/sumup/sumup-ecom-php-sdk/issues/78)) ([72f6ce7](https://github.com/sumup/sumup-ecom-php-sdk/commit/72f6ce7d0f11f10fced3fc230fb5e2c374ecede3))
* **deps:** bump shivammathur/setup-php from 2.29.0 to 2.35.5 ([#77](https://github.com/sumup/sumup-ecom-php-sdk/issues/77)) ([540ffe7](https://github.com/sumup/sumup-ecom-php-sdk/commit/540ffe799e1416f10ed1d39cab2b6dcb897af884))

## [1.4.0](https://github.com/sumup/sumup-ecom-php-sdk/compare/1.3.0...v1.4.0) (2025-11-12)


### Features

* add support for api keys ([#56](https://github.com/sumup/sumup-ecom-php-sdk/issues/56)) ([f5ef00a](https://github.com/sumup/sumup-ecom-php-sdk/commit/f5ef00acb690e519f1ce8b40e2fbfd1438e5b0b4))
* add user-agent with SDK version string ([#69](https://github.com/sumup/sumup-ecom-php-sdk/issues/69)) ([9143957](https://github.com/sumup/sumup-ecom-php-sdk/commit/91439574f8e9e7154ba6a5a930130441b23fa3dd))
* **cd:** add release please setup ([#71](https://github.com/sumup/sumup-ecom-php-sdk/issues/71)) ([f681dd4](https://github.com/sumup/sumup-ecom-php-sdk/commit/f681dd4aa5d448ae02f287c9f14cc64e47d900c9))
* setup tests ([#68](https://github.com/sumup/sumup-ecom-php-sdk/issues/68)) ([59922b6](https://github.com/sumup/sumup-ecom-php-sdk/commit/59922b60e9b94b8cebe28d8af6f87b14c4f5c74e))


### Bug Fixes

* 40: Separator has to be first ([#41](https://github.com/sumup/sumup-ecom-php-sdk/issues/41)) ([fb5f538](https://github.com/sumup/sumup-ecom-php-sdk/commit/fb5f538eaa87549cb6f8f15c38bc4b02f57e0db1))
* bundle tls certificates for platforms without system-wide trust store ([#66](https://github.com/sumup/sumup-ecom-php-sdk/issues/66)) ([3573738](https://github.com/sumup/sumup-ecom-php-sdk/commit/357373873ceb79440ec15c346cb770cd869629fa))
* **utils:** fail gracefully if composer.json can't be parsed ([#65](https://github.com/sumup/sumup-ecom-php-sdk/issues/65)) ([3324d69](https://github.com/sumup/sumup-ecom-php-sdk/commit/3324d695830a3687603c9368dcbb24ea2c57f8a9))
* version in composer.json ([#70](https://github.com/sumup/sumup-ecom-php-sdk/issues/70)) ([524b21b](https://github.com/sumup/sumup-ecom-php-sdk/commit/524b21b0ef58a3f4562df1e7695bea62761966e5))


### Miscellaneous Chores

* **checkouts:** replace pay_to_email with the use of merchant_code ([#58](https://github.com/sumup/sumup-ecom-php-sdk/issues/58)) ([7c6ca69](https://github.com/sumup/sumup-ecom-php-sdk/commit/7c6ca695661cb93b9660c36687f46a5d165014c2))
* deprecate pay_to_email ([#67](https://github.com/sumup/sumup-ecom-php-sdk/issues/67)) ([f279890](https://github.com/sumup/sumup-ecom-php-sdk/commit/f279890c795368c7e3be45930d89a513c1f1ade8))
* **deps:** bump actions/checkout from 4.2.2 to 5.0.0 ([#59](https://github.com/sumup/sumup-ecom-php-sdk/issues/59)) ([a7b4a97](https://github.com/sumup/sumup-ecom-php-sdk/commit/a7b4a978f405a6f422c6fba7a9badbfd6c2527c3))
* **deps:** bump reviewdog/action-actionlint from 1.65.0 to 1.65.2 ([#54](https://github.com/sumup/sumup-ecom-php-sdk/issues/54)) ([2af99fe](https://github.com/sumup/sumup-ecom-php-sdk/commit/2af99fec671287fc3e921c940fe70ded02b06691))
* **deps:** bump reviewdog/action-actionlint from 1.65.2 to 1.68.0 ([#63](https://github.com/sumup/sumup-ecom-php-sdk/issues/63)) ([6291a02](https://github.com/sumup/sumup-ecom-php-sdk/commit/6291a02d7ed2096cb4f5b6e60b4a21400b8bd50e))
* improve error parsing in client ([#64](https://github.com/sumup/sumup-ecom-php-sdk/issues/64)) ([790a68c](https://github.com/sumup/sumup-ecom-php-sdk/commit/790a68c89b3843f73763836893a11a40d169013a))
