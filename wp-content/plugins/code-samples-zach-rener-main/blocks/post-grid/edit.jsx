import React, { useEffect, useState } from "react";
import { __ } from "@wordpress/i18n";
import {
    useBlockProps,
    InspectorControls,
    RichText,
} from "@wordpress/block-editor";
import { PanelBody, RangeControl, SelectControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import "./editor.scss";

/**
 * Utility function to format date strings.
 */
function formatDate(dateString) {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString)
        .toLocaleDateString("en-US", options)
        .toUpperCase();
}

/**
 * Component to render each post item.
 */
function PostItem({ post }) {
    const [featuredImageUrl, setFeaturedImageUrl] = useState(null);

    useEffect(() => {
        // Fetches the featured image URL asynchronously via REST api
        const fetchImage = async () => {
            if (post.featured_media) {
                const response = await fetch(
                    `${window.location.origin}/wp-json/wp/v2/media/${post.featured_media}`
                );
                const data = await response.json();
                setFeaturedImageUrl(data.source_url);
            }
        };
        fetchImage();
    }, [post.featured_media]);

    return (
        <div className="post">
            {featuredImageUrl && (
                <img src={featuredImageUrl} alt={post.title.rendered} />
            )}
            <div className="date">{formatDate(post.date)}</div>
            <h4>{post.title.rendered}</h4>
            {post.excerpt && (
                <div
                    className="excerpt"
                    dangerouslySetInnerHTML={{
                        __html: post.excerpt.rendered,
                    }}
                />
            )}
        </div>
    );
}

/**
 * Main EditComponent using functional components and hooks.
 */
function EditComponent({ attributes, setAttributes }) {
    const { postCount, postType, title } = attributes;

    // Fetch posts using useSelect hook.
    const posts = useSelect(
        (select) => {
            const { getEntityRecords } = select("core");
            return getEntityRecords("postType", postType, {
                per_page: postCount,
            });
        },
        [postCount, postType]
    );

    const inspectorControls = (
        <InspectorControls>
            <PanelBody title={__("Post Grid Settings", "post-grid")}>
                <RangeControl
                    label={__("Number of posts", "post-grid")}
                    value={postCount}
                    onChange={(value) => setAttributes({ postCount: value })}
                    min={1}
                    max={4}
                />
                <SelectControl
                    label={__("Select Post Type", "post-grid")}
                    value={postType}
                    onChange={(value) => setAttributes({ postType: value })}
                    options={[
                        { label: "Page", value: "page" },
                        { label: "Project", value: "projects" },
                        { label: "Article", value: "articles" },
                    ]}
                />
            </PanelBody>
        </InspectorControls>
    );

    const postList =
        posts && posts.map((post) => <PostItem key={post.id} post={post} />);

    return (
        <>
            {inspectorControls}
            <section {...useBlockProps()}>
                <div className="title">
                    <RichText
                        tagName="h3"
                        value={title}
                        allowedFormats={[]}
                        onChange={(newTitle) =>
                            setAttributes({ title: newTitle })
                        }
                        placeholder={__("Enter title...", "text-domain")}
                    />
                </div>
                <div className="posts">{postList}</div>
            </section>
        </>
    );
}

export default EditComponent;
