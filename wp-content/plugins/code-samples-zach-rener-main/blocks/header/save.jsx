import { useBlockProps } from "@wordpress/block-editor";

/**
 * Save function for the custom Gutenberg block.
 *
 * Outputs the static content for the block based on the attributes set in the editor.
 * This content is what is stored in the post content and displayed on the front end.
 *
 */
export default function Save({ attributes }) {
    // Determine the shadow text based on block attributes
    const { content, showShadowText, overrideShadowText, customShadowText } =
        attributes;
    const shadowText = overrideShadowText ? customShadowText : content;

    // Render the block's static content
    return (
        <section {...useBlockProps.save()}>
            <span className="textWrapper">
                <h2>{content}</h2>
                {showShadowText && (
                    <span className="shadow-text">{shadowText}</span>
                )}
            </span>
        </section>
    );
}
