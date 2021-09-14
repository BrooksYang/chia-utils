<?php

namespace BrooksYang\ChiaUtils;

use BrooksYang\ChiaUtils\Exception\ChiaUtilsException;

use function BrooksYang\Bech32m\convertBits;
use function BrooksYang\Bech32m\decode;
use function BrooksYang\Bech32m\encode;
use const BrooksYang\Bech32m\BECH32M;

class ChiaUtils
{
    /**
     * Convert Chia Address to Puzzle Hash
     *
     * @param $address
     * @return string
     * @throws ChiaUtilsException
     */
    public function addressToPuzzleHash($address)
    {
        return "0x" . $this->bytesToHex($this->decodePuzzleHash($address));
    }

    /**
     * Convert Chia Puzzle Hash to Address
     *
     * @param $puzzleHash
     * @return string
     * @throws ChiaUtilsException
     */
    public function puzzleHashToAddress($puzzleHash)
    {
        if (stripos($puzzleHash, '0x') == 0) {
            $puzzleHash = substr($puzzleHash, 2);
        }

        return $this->encodePuzzleHash($this->hexToBytes($puzzleHash), "xch");
    }

    /**
     * @param $address
     * @return int[]
     * @throws ChiaUtilsException
     */
    public function decodePuzzleHash($address)
    {
        $decode = decode($address, BECH32M);

        $hrpgot = $decode[0];
        $data = @$decode[1];
        if ($data == null) {
            throw new ChiaUtilsException("Invalid Address");
        }

        return convertBits($data, count($data), 5, 8, false);
    }

    /**
     * @param $puzzleHash
     * @param $prefix
     * @return string
     * @throws ChiaUtilsException
     */
    public function encodePuzzleHash($puzzleHash, $prefix)
    {
        return encode($prefix, convertBits($puzzleHash, count($puzzleHash), 8, 5), BECH32M);
    }

    /**
     * @param $bytes
     * @return string
     * @throws ChiaUtilsException
     */
    public function bytesToHex($bytes): string
    {
        if ($bytes == null) {
            throw new ChiaUtilsException("Argument bytes of method bytes_to_hex is required and does not have a default value.");
        }
        $hex = "";
        for ($i = 0; $i < count($bytes); $i ++) {
            if (strlen(dechex($bytes[$i])) == 0) {
                $hex .= "00";
            } else if (strlen(dechex($bytes[$i])) == 1) {
                $hex .= "0" . dechex($bytes[$i]);
            } else {
                $hex .= dechex($bytes[$i]);
            }
        }

        return $hex;
    }

    /**
     * @param $hex
     * @return array
     * @throws ChiaUtilsException
     */
    public function hexToBytes($hex)
    {
        if ($hex == null) {
            throw new ChiaUtilsException("Argument hex of method hex_to_bytes is required and does not have a default value.");
        }
        $bytes = [];
        for ($i = 0; $i < strlen($hex); $i += 2) {
            $bytes[$i / 2] = hexdec(substr($hex, $i, 2));
        }

        return $bytes;
    }

    /**
     * Get Coin Info
     * 
     * @param $parentCoinInfo
     * @param $puzzleHash
     * @param $amount
     * @return false|string
     */
    public function getCoinInfo($parentCoinInfo, $puzzleHash, $amount)
    {
        $amount = bcmul($amount, pow(10, 12), 0);
        if (stripos($parentCoinInfo, '0x') == 0) {
            $parentCoinInfo = substr($parentCoinInfo, 2);
        }
        if (stripos($puzzleHash, '0x') == 0) {
            $puzzleHash = substr($puzzleHash, 2);
        }

        $a = pack("H*", $parentCoinInfo);
        $b = pack("H*", $puzzleHash);
        $amountHex = base_convert($amount, 10, 16);
        if (strlen($amountHex) % 2 == 1) {
            $amountHex = '0' . $amountHex;
        }
        $c = pack("H*", $amountHex);

        return '0x' . hash('sha256', $a . $b . $c);
    }
}
