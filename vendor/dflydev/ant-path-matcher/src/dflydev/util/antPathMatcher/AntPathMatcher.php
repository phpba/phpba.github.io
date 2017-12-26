<?php

/*
 * This file is a part of the Ant Path Matcher library.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\util\antPathMatcher;

/**
 * Default implementation for Ant-style path patterns.
 *
 * <p>This was very much inspired (read: "kindly borrowed") from <a href="http://www.springsource.org/">Spring</a>.
 *
 */
class AntPathMatcher implements IAntPathMatcher
{
    /**
     * (non-PHPdoc)
     * @see dflydev\util\antPathMatcher.IAntPathMatcher::isPattern()
     */
    public function isPattern($path)
    {
        return strstr($path, '*') !== false or strstr($path, '?') !== false or '/' == substr($path, '-1');
    }

    /**
     * (non-PHPdoc)
     * @see dflydev\util\antPathMatcher.IAntPathMatcher::match()
     */
    public function match($pattern, $path)
    {
        return $this->doMatch($pattern, $path, true);
    }

    /**
     * (non-PHPdoc)
     * @see dflydev\util\antPathMatcher.IAntPathMatcher::matchStart()
     */
    public function matchStart($pattern, $path)
    {
        return $this->doMatch($pattern, $path, false);
    }

    /**
     * Actually match the given <code>path</code> against the given <code>pattern</code>.
     * @param  string  $pattern
     * @param  string  $path
     * @param  boolean $fullMatch
     * @return boolean
     */
    protected function doMatch($pattern, $path, $fullMatch)
    {

        if (($pattern[0] == '/') != ($path[0] == '/')) {
            return false;
        }
        if ('/' == substr($pattern, '-1')) {
            $pattern .= '**';
        }

        $pattDirs = $this->tokenizeToStringArray($pattern);
        $pathDirs = $this->tokenizeToStringArray($path);

        $pattIdxStart = 0;
        $pattIdxEnd = count($pattDirs) - 1;
        $pathIdxStart = 0;
        $pathIdxEnd = count($pathDirs) - 1;

        // Match all elements up to the first **
        while ($pattIdxStart <= $pattIdxEnd and $pathIdxStart <= $pathIdxEnd) {
            $patDir = $pattDirs[$pattIdxStart];
            if ('**' == $patDir) {
                break;
            }
            if (!$this->matchStrings($patDir, $pathDirs[$pathIdxStart])) {
                return false;
            }
            $pattIdxStart++;
            $pathIdxStart++;
        }

        if ($pathIdxStart > $pathIdxEnd) {
            // Path is exhausted, only match if rest of pattern is * or **'s
            if ($pattIdxStart > $pattIdxEnd) {
                return ('/' == substr($pattern, '-1') ? '/' == substr($path, '-1') :
                        !('/' == substr($path, '-1')));
            }
            if (!$fullMatch) {
                return true;
            }
            if ($pattIdxStart == $pattIdxEnd and '*' == $pattDirs[$pattIdxStart] and '/' == substr($path, -1)) {
                return true;
            }
            for ($i = $pattIdxStart; $i <= $pattIdxEnd; $i++) {
                if (!'**' == $pattDirs[$i]) {
                    return false;
                }
            }

            return false;
        } elseif ($pattIdxStart > $pattIdxEnd) {
            // String not exhausted, but pattern is. Failure.
            return false;
        } elseif (!$fullMatch and "**" == $pattDirs[$pattIdxStart]) {
            // Path start definitely matches due to "**" part in pattern.
            return true;
        }

        // up to last '**'
        while ($pattIdxStart <= $pattIdxEnd and $pathIdxStart <= $pathIdxEnd) {
            $patDir = $pattDirs[$pattIdxEnd];
            if ('**' == $patDir) {
                break;
            }
            if (!$this->matchStrings($patDir, $pathDirs[$pathIdxEnd])) {
                return false;
            }
            $pattIdxEnd--;
            $pathIdxEnd--;
        }
        if ($pathIdxStart > $pathIdxEnd) {
            // String is exhausted
            for ($i = $pattIdxStart; $i <= $pattIdxEnd; $i++) {
                if (!('**' == $pattDirs[$i])) {
                    return false;
                }
            }

            return true;
        }

        while ($pattIdxStart != $pattIdxEnd and $pathIdxStart <= $pathIdxEnd) {
            $patIdxTmp = -1;
            for ($i = $pattIdxStart + 1; $i <= $pattIdxEnd; $i++) {
                if ('**' == $pattDirs[$i]) {
                    $patIdxTmp = $i;
                    break;
                }
            }
            if ($patIdxTmp == $pattIdxStart + 1) {
                // '**/**' situation, so skip one
                $pattIdxStart++;
                continue;
            }

            // Find the pattern between padIdxStart & padIdxTmp in str between
            // strIdxStart & strIdxEnd
            $patLength = ($patIdxTmp - $pattIdxStart - 1);
            $strLength = ($pathIdxEnd - $pathIdxStart + 1);
            $foundIdx = -1;

            for ($i = 0; $i <= $strLength - $patLength; $i++) {
                for ($j = 0; $j < $patLength; $j++) {
                    $subPat = $pattDirs[$pattIdxStart + $j + 1];
                    $subStr = $pathDirs[$pathIdxStart + $i + $j];
                    if (!$this->matchStrings($subPat, $subStr)) {
                        continue 2;
                    }
                }
                $foundIdx = $pathIdxStart + $i;
                break;
            }

            if ($foundIdx == -1) {
                return false;
            }

            $pattIdxStart = $patIdxTmp;
            $pathIdxStart = $foundIdx + $patLength;

        }

        for ($i = $pattIdxStart; $i <= $pattIdxEnd; $i++) {
            if (!'**' == $pattDirs[$i]) {
                return false;
            }
        }

        return true;

    }

    protected function tokenizeToStringArray($str, $delimiter = '/', $trimTokens = true, $ignoreEmptyTokens = true)
    {
        if ($str === null) { return null; }
        $tokens = array();
        foreach (explode($delimiter, $str) as $token) {
            if ($trimTokens) {
                $token = trim($token);
            }
            if (!$ignoreEmptyTokens or strlen($token)>0) {
                $tokens[] = $token;
            }
        }

        return $tokens;
    }

    private function matchStringsCallback($matches)
    {
        switch ($matches[0]) {
            case '?':
                return '.';
                break;
            case '*':
                return '.*';
                break;
            case '.':
            case '+':
                return '\\' . $matches[0];
                break;
        }
        throw new \InvalidArgumentException('Path contains invalid character: ' . $matches[0]);
    }
    protected function matchStrings($pattern, $str)
    {
        $re = preg_replace_callback('([\?\*\.\+])', array($this, 'matchStringsCallback'), $pattern);

        return preg_match('/'.$re.'/', $str);
    }

}
