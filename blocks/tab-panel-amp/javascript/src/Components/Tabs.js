import React from 'react';
import Header from "./Header/Header";
import Content from "./Content/Content";

export default class Tabs extends React.Component
{
    constructor(props) {
        super(props);

        this.state = {
            activeTab: 0
        }
    }

    setActiveTab(i) {
        this.setState(
            {
                activeTab: i
            }
        )
    }

    render() {
        return (
            <div className={this.props.className}>
                <Header
                    attributes={this.props.attributes}
                    setAttributes={this.props.setAttributes}
                />
                <Content
                    attributes={this.props.attributes}
                    setAttributes={this.props.setAttributes}
                />
            </div>
        )
    }
}