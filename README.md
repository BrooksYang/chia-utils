# Chia Utils

### Install
```
composer require brooksyang/chia-utils
```

### Usage
New Instance.
```php
$chiaUtils = new ChiaUtils();
```

Convert Chia Address to Puzzle Hash.
```php
$chiaUtils->addressToPuzzleHash('xch189j3nf9anmwx2yex7xnrz0lrqzsanwatpjx8h0l5nqcdjpttl0ystkzf8t');

> 0x396519a4bd9edc651326f1a6313fe300a1d9bbab0c8c7bbff49830d9056bfbc9
```

Convert Chia Puzzle Hash to Address.
```php
$chiaUtils->puzzleHashToAddress('0x396519a4bd9edc651326f1a6313fe300a1d9bbab0c8c7bbff49830d9056bfbc9');

> xch189j3nf9anmwx2yex7xnrz0lrqzsanwatpjx8h0l5nqcdjpttl0ystkzf8t
```

Get Coin Info
```php
$parentCoinId = '0xf06c9fe019ab67bc87de15b44b5b05da7af1ffbd3b3d390c6cd77ca832fc31d8';
$puzzleHash = '0xf3d54989b6ccf5d386f7c57e91678176ed0187aeaca849a32c4646ba603b7e6e';
$amount = 0.01;
$this->getCoinInfo($parentCoinId, $puzzleHash, $amount);

> 0x2d9dadc33ae71e0452f96c9544d2040275c9b37025c42764b0017a63cc8a2af6
```

### Donations
- TRX: ```TB8gbB3erNn96poiMumkzX7my4Em9Lx9oG```
- XCH: ```xch1w0k7fwzrdkt8xqth45zln0d9anvw7gs26lkgv3yhngrdct7hkpmqdpyhmp```
