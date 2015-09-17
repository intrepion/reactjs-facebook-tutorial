
/**
 * This is the chat header component,
 * Data inside this is static based on the browser url
 */
var ChatHeader = React.createClass({
  render: function() {
    // To display the username
    if (/user_id=1/i.test(window.location.search)) {
      name = 'John';
    } else {
      name = 'Scott';
    }

    return (
      <div className="msg-wgt-header">
        <a href="#">{name}</a>
      </div>
    );
  }
});

// This is the chat row component
var Row = React.createClass({
  render: function() {
    return (
      <div className="msg-row-container">
        <div className="msg-row">
          <div className="avatar"></div>
          <span className="user-label">
            <a href="#" className="chat-username">{this.props.username}</a> <span className="msg-time">{this.props.time}</span>
          </span><br/>
          {this.props.message}
        </div>
      </div>
    );
  }
});

/**
 * Messages component
 */
var Messages = React.createClass({
  render: function() {
    // This is how you set inline styles in React
    var inlineStyles = {
      height: '300px',
      overflowY: 'scroll'
    };

    // Loop through the list of chats and create array of Row components
    var Rows = this.props.datas.map(function(data) {
      return (
        <Row key={data.id} username={data.username} time={data.time} message={data.message} />
      )
    });

    return (
      <div style={inlineStyles}>
        {Rows}
      </div>
    );
  }
});

/**
 * This component contains the chat textarea
 */
var ChatFooter = React.createClass({
  // Message send event handler
  handleUserMessage: function(event) {
    // When shift and enter key is pressed
    if (event.shiftKey && event.keyCode === 13) {
      var msg = this.refs.textArea.getDOMNode().value.trim();
      if (msg !== '') {
        // call the sendmessages of ChatContainer throught the props
        this.props.sendMessage(msg);
      }
      // Prevent default and clear the textarea
      event.preventDefault();
      this.refs.textArea.getDOMNode().value = null;
    }
  },

  render: function() {
    return (
      <div className="msg-wgt-footer">
        <textarea id="chatMsg" ref="textArea" onKeyDown={this.handleUserMessage} placeholder="Type your message. Press shift + Enter to send" />
      </div>
    );
  }
});

var ChatContainer = React.createClass({
  // Load the initial chats
  getInitialState: function() {
    return {datas: []};
  },

  // Get's the list of messages from the server and set's the state,
  // so that it re-renders the Messages
  getMessages: function() {
    $.ajax({
      url: 'messages',
      dataType: 'json',
      success: function(data) {
        this.setState({datas: data});
      }.bind(this)
    });
  },

  // Will add a new message and update the messages list
  sendMessage: function(message) {
    var that = this;
    $.ajax({
      url: 'messages',
      method: 'post',
      dataType: 'json',
      data: {msg: message},
      success: function(data) {
        this.setState({datas: data});
      }.bind(this)
    });
  },

  componentDidMount: function() {
    // get the list of messages
    this.getMessages();
    // set the poll interval
    setInterval(this.getMessages, 5000);
  },

  render: function() {
    return (
      <div className="chat-container">
        <ChatHeader />
        <Messages datas={this.state.datas} />
        <ChatFooter sendMessage={this.sendMessage} />
      </div>
    );
  }
});

// React entry point
React.render(
  <ChatContainer />,
  document.getElementById('container')
);
