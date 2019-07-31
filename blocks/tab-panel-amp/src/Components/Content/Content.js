import React from 'react';
import ContentTab from "./ContentTab";

export default class Content extends React.Component
{
    render() {
        return (
            <div className="contents">
                {this.props.attributes.tabs.map((tab, i) => {
                    return (
                        <ContentTab
                            attributes={this.props.attributes}
                            setAttributes={this.props.setAttributes}
                            item={tab}
                            index={i}
                        />
                    )
                })}
            </div>
        )
    }
}