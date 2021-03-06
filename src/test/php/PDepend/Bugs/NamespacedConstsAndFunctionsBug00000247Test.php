<?php
/**
 * This file is part of PDepend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2016, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright 2008-2016 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link    https://github.com/pdepend/pdepend/issues/247
 */

namespace PDepend\Bugs;

use PDepend\Source\Builder\Builder;
use PDepend\Source\Tokenizer\Tokenizer;
use PDepend\Util\Cache\CacheDriver;

/**
 * Test case for bug #247.
 *
 * @copyright 2008-2016 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link    https://github.com/pdepend/pdepend/issues/247
 *
 * @ticket 247
 * @covers \stdClass
 * @group regressiontest
 */
class NamespacedConstsAndFunctionsBug00000247Test extends AbstractRegressionTest
{
    /**
     * testUseConst
     *
     * @return void
     */
    public function testUseConst()
    {
        $method = $this->getFirstClassMethodForTestCase();

        $actual = array();
        foreach ($method->findChildrenOfType('PDepend\\Source\\AST\\ASTConstant') as $reference) {
            $actual[] = $reference->getImage();
        }

        $this->assertEquals(
            array(
                '\Bar\BAZ',
                '\SOMETHING',
                '\TEST',
            ),
            $actual
        );
    }

    /**
     * testUseFunction
     *
     * @return void
     */
    public function testUseFunction()
    {
        $method = $this->getFirstClassMethodForTestCase();

        $actual = array();
        foreach ($method->findChildrenOfType('PDepend\\Source\\AST\\ASTFunctionPostfix') as $reference) {
            $actual[] = $reference->getImage();
        }

        $this->assertEquals(
            array(
                '\Bar\baz',
                '\something',
                '\test',
            ),
            $actual
        );
    }

    /**
     * @param \PDepend\Source\Tokenizer\Tokenizer $tokenizer
     * @param \PDepend\Source\Builder\Builder $builder
     * @param \PDepend\Util\Cache\CacheDriver $cache
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createPHPParser(Tokenizer $tokenizer, Builder $builder, CacheDriver $cache)
    {
        return $this->getAbstractClassMock(
            'PDepend\\Source\\Language\\PHP\\PHPParserVersion56',
            array($tokenizer, $builder, $cache)
        );
    }
}
