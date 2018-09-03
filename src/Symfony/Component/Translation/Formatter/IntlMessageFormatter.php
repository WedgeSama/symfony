<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Formatter;

/**
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
class IntlMessageFormatter implements MessageFormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format($message, $locale, array $parameters = array())
    {
        try {
            $formatter = new \MessageFormatter($locale, $message);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException('Invalid message format.', $e);
        }
        if (null === $formatter) {
            throw new \InvalidArgumentException(sprintf('Invalid message format. Reason: %s (error #%d)', intl_get_error_message(), intl_get_error_code()));
        }

        $message = $formatter->format($parameters);
        if (U_ZERO_ERROR !== $formatter->getErrorCode()) {
            throw new \InvalidArgumentException(sprintf('Unable to format message. Reason: %s (error #%s)', $formatter->getErrorMessage(), $formatter->getErrorCode()));
        }

        return $message;
    }
}
