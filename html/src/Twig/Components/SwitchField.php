<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Catalyst switch (https://catalyst.tailwindui.com/docs/switch) rendered without JavaScript.
 *
 * A real <input type="checkbox" role="switch"> sits invisibly over the drawn switch,
 * so clicks, keyboard and form submission work natively; the styles read its state
 * with Tailwind's has-checked / group-has-checked variants.
 *
 * Usage:
 *   <twig:SwitchField name="allow_embedding" label="Allow embedding" description="..." checked />
 *
 * Any extra attribute (class, data-action, onchange...) is put on the wrapper.
 */
#[AsTwigComponent]
final class SwitchField
{
    /** The color variant the switch should use (see the colors map in the template). */
    public string $color = 'dark/zinc';

    /** Whether or not to disable the switch. */
    public bool $disabled = false;

    /** The name to use when submitting an HTML form. */
    public ?string $name = null;

    /** The value to use when submitting an HTML form (Catalyst / browser default: "on"). */
    public string $value = 'on';

    /** The initial state of the switch. */
    public bool $checked = false;

    /** The id of the input; generated when not given. */
    public ?string $id = null;

    /** Text of the label; without a label, only the switch itself is rendered. */
    public ?string $label = null;

    /** Optional help text displayed under the label. */
    public ?string $description = null;

    public function mount(?string $id = null): void
    {
        $this->id = $id ?? 'switch-'.bin2hex(random_bytes(4));
    }
}
