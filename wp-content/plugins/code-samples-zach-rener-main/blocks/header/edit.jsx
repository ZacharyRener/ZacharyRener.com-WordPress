import { __ } from "@wordpress/i18n";
import {
    useBlockProps,
    RichText,
    InspectorControls,
} from "@wordpress/block-editor";
import { PanelBody, ToggleControl, TextControl } from "@wordpress/components";
import "./editor.scss";

/**
 * Edit component for the custom Gutenberg block.
 *
 * This component allows users to edit the block's attributes, including
 * the main content, whether to show shadow text, and custom shadow text options.
 *
 */
export default function Edit({ attributes, setAttributes }) {
    // Determine the shadow text based on block attributes
    const shadowText = attributes.overrideShadowText
        ? attributes.customShadowText
        : attributes.content;

    // Inspector controls for block settings
    const inspectorControls = (
        <InspectorControls>
            <PanelBody title={__("Settings", "text-domain")}>
                <ToggleControl
                    checked={!!attributes.showShadowText}
                    label={__("Show shadow text", "text-domain")}
                    onChange={() =>
                        setAttributes({
                            showShadowText: !attributes.showShadowText,
                        })
                    }
                />
                {attributes.showShadowText && (
                    <ToggleControl
                        checked={!!attributes.overrideShadowText}
                        label={__("Override shadow text", "text-domain")}
                        onChange={() =>
                            setAttributes({
                                overrideShadowText:
                                    !attributes.overrideShadowText,
                            })
                        }
                    />
                )}
                {attributes.showShadowText && attributes.overrideShadowText && (
                    <TextControl
                        label={__("Custom shadow text", "text-domain")}
                        value={attributes.customShadowText || ""}
                        onChange={(customShadowText) =>
                            setAttributes({ customShadowText })
                        }
                    />
                )}
            </PanelBody>
        </InspectorControls>
    );

    // Render the edit UI
    return (
        <>
            {inspectorControls}
            <section {...useBlockProps()}>
                <span className="textWrapper">
                    <RichText
                        tagName="h2"
                        value={attributes.content}
                        allowedFormats={[]}
                        onChange={(content) => setAttributes({ content })}
                        placeholder={__("Enter header...", "text-domain")}
                    />
                    {attributes.showShadowText && (
                        <span className="shadow-text">{shadowText}</span>
                    )}
                </span>
            </section>
        </>
    );
}
