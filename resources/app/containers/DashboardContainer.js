/**
 * DashboardContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import MyTodo from './../components/MyTodo';
import {connect} from 'react-redux';
import * as actionCreators from './../actions';
import {getTodos} from './../helpers/sdk';

class DashboardContainer extends React.Component {
  componentWillMount() {
    this.props.getTodos(this.props.auth.accessToken);
  }

  render() {
    return (
      <MyTodo items={this.props.todos}
              visibilityFilter={this.props.visibilityFilter}
              addTodo={this.props.addTodo}
              toggleCompleted={this.props.toggleCompleted}
              setVisibilityFilter={this.props.setVisibilityFilter}
              resetTodo={this.props.resetTodo}/>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    todos: state.todos,
    visibilityFilter: state.visibilityFilter,
    auth: state.auth
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
    getTodos: (accessToken) => {
      getTodos(accessToken).then(function (response) {
        dispatch(actionCreators.getTodos(response));
      }).catch(function (error) {
        console.log('Failed fetching ToDos');
        console.log(error);
      });
    },
    addTodo: (e) => {
      e.preventDefault();
      var todoName = $("#todo_name");
      dispatch(actionCreators.addTodo(todoName.val()));
      todoName.val('');
    },
    toggleCompleted: (e) => {
      var id = $(e.target).closest("input").attr('id');
      dispatch(actionCreators.toggleCompleted(id));
    },
    setVisibilityFilter: (e) => {
      var filter = $(e.target).closest("button").attr('id');
      dispatch(actionCreators.setVisibilityFilter(filter));
    },
    resetTodo: () => {
      dispatch(actionCreators.resetTodo());
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(DashboardContainer);