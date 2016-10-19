import React from 'react';

export default class About extends React.Component {
  render() {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h2>About</h2>
          <p>Mauris sem velit, vehicula eget sodales vitae, rhoncus eget sapien:</p>
          <ol>
            <li>Nulla pulvinar diam</li>
            <li>Facilisis bibendum</li>
            <li>Vestibulum vulputate</li>
            <li>Eget erat</li>
            <li>Id porttitor</li>
          </ol>
          <div className="content">
            {this.props.children}
          </div>
        </div>
      </div>
    );
  }
}
