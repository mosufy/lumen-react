import React from 'react';

export default class SiteLogoComponent extends React.Component {
  render() {
    var logoTitle;

    if (this.props.pageTemplate == 'public') {
      logoTitle = 'My TODOs';
    } else {
      logoTitle = 'Welcome, User';
    }

    return (
      <h3 className="text-muted">{logoTitle}</h3>
    );
  }
}