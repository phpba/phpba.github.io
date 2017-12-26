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
 * Ant-style path pattern matching. Examples are provided below.
 *
 * <p>Some examples:<br> <ul> <li><code>com/t?st.jsp</code> - matches <code>com/test.jsp</code> but also
 * <code>com/tast.jsp</code> or <code>com/txst.jsp</code></li> <li><code>com/*.jsp</code> - matches all
 * <code>.jsp</code> files in the <code>com</code> directory</li> <li><code>com/&#42;&#42;/test.jsp</code> - matches all
 * <code>test.jsp</code> files underneath the <code>com</code> path</li> <li><code>org/springframework/&#42;&#42;/*.jsp</code>
 * - matches all <code>.jsp</code> files underneath the <code>org/springframework</code> path</li>
 * <li><code>org/&#42;&#42;/servlet/bla.jsp</code> - matches <code>org/springframework/servlet/bla.jsp</code> but also
 * <code>org/springframework/testing/servlet/bla.jsp</code> and <code>org/servlet/bla.jsp</code></li> </ul>
 */
interface IAntPathMatcher {

    /**
     * Does the given <code>path</code> represent a pattern that can be matched
     * by an implementation of this interface? If this method returns
     * <code>false</code> then the <code>match*</code> methods do not need to be
     * called since direct string comparisons will lead to the same results.
     *
     * @return boolean
     */
    public function isPattern($path);

    /**
     * Match the given <code>path</code> against the given <code>pattern</code>.
     * @param  string  $pattern
     * @param  string  $path
     * @return boolean
     */
    public function match($pattern, $path);

    /**
     * Match the given <code>path</code> against the corresponding part of the
     * given <code>pattern</code>.
     *
     * Determines whether the pattern at least matches as far as the given base
     * path goes, assuming that a full path may then match as well.
     * @param  string  $pattern
     * @param  string  $path
     * @return boolean
     */
    public function matchStart($pattern, $path);

}
